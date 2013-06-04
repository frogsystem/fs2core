<?php

#   Copyright (C) 2006-2012 Tobias Leupold <tobias.leupold@web.de>
#
#   This file is part of the b8 package
#
#   This program is free software; you can redistribute it and/or modify it
#   under the terms of the GNU Lesser General Public License as published by
#   the Free Software Foundation in version 2.1 of the License.
#
#   This program is distributed in the hope that it will be useful, but
#   WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
#   or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public
#   License for more details.
#
#   You should have received a copy of the GNU Lesser General Public License
#   along with this program; if not, write to the Free Software Foundation,
#   Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, USA.

/**
 * The PDO MySQL backend for communicating with the database.
 * Copyright (C) 2009 Oliver Lillie
 * Copyright (C) 2010-2012 Tobias Leupold <tobias.leupold@web.de>
 * Copyright (C) 2013 Thoronador
 *
 * @license LGPL 2.1
 * @access public
 * @package b8
 * @author Oliver Lillie (original PHP 5 port and optimizations)
 * @author Tobias Leupold
 */

class b8_storage_mysql extends b8_storage_base
{

	public $config = array(
		'database'   => 'b8_wordlist',
		'table_name' => 'b8_wordlist',
		'host'       => 'localhost',
		'user'       => FALSE,
		'pass'       => FALSE,
		'connection' => NULL
	);

	private $_connection = NULL;

	private $_deletes = array();
	private $_puts    = array();
	private $_updates = array();

	/**
	 * Constructs the backend.
	 *
	 * @access public
	 * @param string $config
	 */

	function __construct($config, &$degenerator)
	{

		# Pass the degenerator instance to this class
		$this->degenerator = $degenerator;

		# Validate the config items

		foreach($config as $name => $value) {

			switch($name) {

				case 'table_name':
				case 'host':
				case 'user':
				case 'pass':
				case 'database':
					$this->config[$name] = (string) $value;
					break;

				case 'connection':
					$this->config['connection'] = $value;
					break;

				default:
					throw new Exception("b8_storage_mysql: Unknown configuration key: \"$name\"");

			}

		}

		# Connect to the database

		if($this->config['connection'] !== NULL) {

			# An object has been passed, so check if it's okay.

			if(is_object($this->config['connection']) === TRUE) {

				$class_name = get_class($this->config['connection']);

				if($class_name != 'PDO')
					throw new Exception('b8_storage_mysql: The object passed via the "connection" paramter is no PDO object.');

			}
			else
				throw new Exception('b8_storage_mysql: The object passed via the "connection" paramter is no object.');

			# If we reach here, we can use the passed object.
			$this->_connection = $this->config['connection'];

		}

		else {

			# We have to connect.
            /* Throws an exception if connection could not be established, so
               we better catch that, because the backtrace will usually contain
               all the connection data, including MySQL user and password. */
            try {
			  $this->_connection = new PDO('mysql:host='.$this->config['host'].';dbname='.$this->config['database'], $this->config['user'], $this->config['pass']);
			}
			catch (Exception $e)
            {
              Throw new Exception('b8_storage_mysql: No Connection to Database, '.$e->getMessage());
            }
		}

		# Check to see if the wordlist table exists
		$stmt = $this->_connection->query('DESCRIBE `' . $this->config['table_name'] . '`');
		if($stmt === FALSE)
		{
		    $info = $this->_connection->errorInfo();
			throw new Exception('b8_storage_mysql: ' . $info[2]);
		}

		# Let's see if this is a b8 database and the version is okay
		$this->check_database();

	}

	/**
	 * Closes the database connection.
	 *
	 * @access public
	 * @return void
	 */

	function __destruct()
	{

		# Commit any changes before closing
		$this->_commit();

		# Just close the connection if no PDO object was passed and b8 created its own connection.
		if($this->config['connection'] === NULL)
			$this->_connection = NULL;

	}

	/**
	 * Does the actual interaction with the database when fetching data.
	 *
	 * @access protected
	 * @param array $tokens
	 * @return mixed Returns an array of the returned data in the format array(token => data) or an empty array if there was no data.
	 */

	protected function _get_query($tokens)
	{

		# Construct the query ...

		if(count($tokens) > 1) {

			# We have more than 1 token

			$where = array();

			foreach ($tokens as $token) {
				$token = $this->_connection->quote($token);
				array_push($where, $token);
			}

			$where = "token IN (" . implode(", ", $where) . ")";
		}

		elseif(count($tokens) == 1) {
			# We have exactly one token
			$token = $this->_connection->quote($tokens[0]);
			$where = "token = " . $token;
		}

		elseif(count($tokens) == 0) {
			# We have no tokens
			# This can happen when we do a degenerates lookup and we don't have any degenerates.
			return array();
		}

		# ... and fetch the data

		$result = $this->_connection->query('
			SELECT token, count_ham, count_spam
			FROM `' . $this->config['table_name'] . '`
			WHERE ' . $where . ';');

		# Check if anything matched the query
		if($result === FALSE)
			return array();

		$data = array();

		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[$row['token']] = array(
				'count_ham'  => $row['count_ham'],
				'count_spam' => $row['count_spam']
			);
		}

		$result = NULL;

		return $data;

	}

	/**
	 * Store a token to the database.
	 *
	 * @access protected
	 * @param string $token
	 * @param string $count
	 * @return void
	 */

	protected function _put($token, $count)
	{

		$token = $this->_connection->quote($token);

		$count_ham = $this->_connection->quote($count['count_ham']);
		$count_spam = $this->_connection->quote($count['count_spam']);

		array_push($this->_puts, "($token, $count_ham, $count_spam)");

	}

	/**
	 * Update an existing token.
	 *
	 * @access protected
	 * @param string $token
	 * @param string $count
	 * @return void
	 */

	protected function _update($token, $count)
	{

		$token = $this->_connection->quote($token);

		$count_ham = $this->_connection->quote($count['count_ham']);
		$count_spam = $this->_connection->quote($count['count_spam']);

		array_push($this->_updates, "($token, $count_ham, $count_spam)");

	}

	/**
	 * Remove a token from the database.
	 *
	 * @access protected
	 * @param string $token
	 * @return void
	 */

	protected function _del($token)
	{

		$token = $this->_connection->quote($token);

		array_push($this->_deletes, $token);

	}

	/**
	 * Commits any modification queries.
	 *
	 * @access protected
	 * @return void
	 */

	protected function _commit()
	{

		if(count($this->_deletes) > 0) {

			$result = $this->_connection->query("
				DELETE FROM `{$this->config['table_name']}`
				WHERE token IN (" . implode(", ", $this->_deletes) . ");");

			if(is_object($result) === TRUE)
				$result = NULL;

			$this->_deletes = array();

		}

		if(count($this->_puts) > 0) {

			$result = $this->_connection->query("
				INSERT INTO `{$this->config['table_name']}`(token, count_ham, count_spam)
				VALUES " . implode(', ', $this->_puts) . ';');

			if(is_object($result) === TRUE)
				$result = NULL;

			$this->_puts = array();

		}

		if(count($this->_updates) > 0) {

			$result = $this->_connection->query("
				INSERT INTO `{$this->config['table_name']}`(token, count_ham, count_spam)
				VALUES " . implode(', ', $this->_updates) . "
				ON DUPLICATE KEY UPDATE
					`{$this->config['table_name']}`.count_ham = VALUES(count_ham),
					`{$this->config['table_name']}`.count_spam = VALUES(count_spam);");

			if(is_object($result) === TRUE)
				$result = NULL;

			$this->_updates = array();

		}

	}

}

?>
