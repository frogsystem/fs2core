<?php
/**
 * @file     Event.php
 * @folder   /libs/Event
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * Implementation of Frogsystem2\Event\EventInterface
 */

namespace Frogsystem2\Event;

class Event implements EventInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $target = null;

    /**
     * @var array
     */
    protected $parameters = array();

    /**
     * @var bool
     */
    protected $stopped = false;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * {@inheritdoc}
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function stopPropagation($flag = true)
    {
        $this->stopped = (bool) $flag;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function propagationStopped()
    {
        return $this->stopped;
    }

}