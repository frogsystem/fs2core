<?php
/**
 * @file     class_hash.php
 * @folder   /libs
 * @version  0.1
 * @author   Sweil
 *
 * this class provides access and datahandling for confirment hashes
 */
require('class_Hash.php');

class HashMapper
{
    // Klassen-Variablen
    private $sql;

    // Der Konstruktur
    public function  __construct() {
        global $FD;
        $this->sql = $FD->sql();
    }

    // Hash laden
    private function getById($id) {
        $data = $this->sql->conn()->query(
                        'SELECT * FROM '.$this->sql->getPrefix().'hashes
                         WHERE id = '.intval($id).' LIMIT 1');
        $data = $data->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
			$hash = new Hash($data);
            if ($this->checkDeleteTime($hash))
                return $hash;
		}

        Throw new Exception('Hash not found.');
    }

    public function getByHash($hash) {
        $data = $this->sql->conn()->prepare(
                        'SELECT * FROM '.$this->sql->getPrefix().'hashes
                         WHERE hash = ? LIMIT 1');
        $data->execute(array($hash));
        $data = $data->fetch(PDO::FETCH_ASSOC);

        if (!empty($data)) {
			$hash = new Hash($data);
            if ($this->checkDeleteTime($hash))
                return $hash;
		}

        Throw new Exception('Hash not found.');
    }

    public function checkDeleteTime($hash) {
        global $FD;

        if ($hash->getDeleteTime() < $FD->cfg('env', 'date')) {
            $this->delete($hash);
            return false;
        }
        return true;
    }


    // save to DB
    public function save($hash) {
        $data = array(
            'hash' => $hash->getHash(),
            'type' => $hash->getType(),
            'typeId' => $hash->getTypeId()
        );

        // no ID?
        if (null === ($data['id'] = $hash->getId()))
            unset($data['id']);

        // save to db
        try {
            $id = $this->sql->save('hashes', $data);
            return $this->getById($id);
        } catch (Exception $e) {
            Throw $e;
        }
    }

    // delete from DB
    public function delete($hash) {
        global $FD;
        $this->sql->conn()->exec('DELETE FROM '.$FD->config('pref').'hashes
                                  WHERE id = '.intval($hash->getId()));
    }

    // delete from DB by deleteTime
    public static function deleteByTime($time = null) {
        global $FD;

        if (empty($time))
            $time = $FD->env('time');

        $FD->sql()->conn()->exec('DELETE FROM '.$FD->config('pref').'hashes
                                  WHERE `deleteTime` < '.intval($time));
    }


    // create new hash for a new Password Request
    public function createForNewPassword($userid) {
        $hash = new Hash();
        $hash->setHash($this->calculateHash());
        $hash->setType('newpassword');
        $hash->setTypeId($userid);
        $hash->setDeleteTime(time()+2*24*60*60);
        return $this->save($hash);
    }


    // Calculate Hash
    private function calculateHash() {
        $LENGHT = 40;
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789';
        $hash = '';
        $real_strlen = strlen ( $charset ) - 1;
        mt_srand ( (double)microtime () * 1001000 );

        while ( strlen ( $hash ) < $LENGHT ) {
            $hash .= $charset[mt_rand ( 0,$real_strlen ) ];
        }
        return $hash;
    }
}
?>
