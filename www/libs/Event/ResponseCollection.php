<?php
/**
 * @file     ResponseCollection.php
 * @folder   /libs/Event
 * @version  0.4
 * @author   Satans Krümelmonster
 *
 * Interface for the EventManager
 */

namespace Frogsystem2\Event;


class ResponseCollection extends \SplStack
{
    /**
     * @var bool
     */
    protected $stopped = false;

    /**
     * @return boolean
     */
    public function hasStopped()
    {
        return $this->stopped;
    }

    /**
     * @param boolean $stopped
     * @return $this
     */
    public function setStopped($stopped)
    {
        $this->stopped = (bool) $stopped;
        return $this;
    }

    /**
     * Get the first result.
     * If there is no result, null is returned.
     * @return mixed
     */
    public function first()
    {
        if($this->count() > 0)
        {
            return $this->bottom();
        }

        return null;
    }

    /**
     * Get the last result.
     * If there is no result, null is returned.
     * @return mixed
     */
    public function last()
    {
        if($this->count() > 0)
        {
            return $this->top();
        }

        return null;
    }
}