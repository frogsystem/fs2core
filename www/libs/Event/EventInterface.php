<?php
/**
 * @file     EventInterface.php
 * @folder   /libs/Event
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * Interface for an event
 */
namespace Frogsystem2\Event;


interface EventInterface
{
    /**
     * Get the event's name.
     * @return string
     */
    public function getName();

    /**
     * Set the event's name
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get the event's target.
     * @return mixed
     */
    public function getTarget();

    /**
     * Set the event's target.
     * @param mixed $target
     * @return $this
     */
    public function setTarget($target);

    /**
     * Get the event's parameters
     * @return array
     */
    public function getParameters();

    /**
     * Set the event's parameters
     * @param array|\Traversable $parameters
     * @return $this
     */
    public function setParameters($parameters);

    /**
     * Stop the event's propagation
     * @param bool $flag
     * @return void
     */
    public function stopPropagation($flag = true);

    /**
     * Should the propagation of this event stop?
     * @return bool
     */
    public function propagationStopped();
}