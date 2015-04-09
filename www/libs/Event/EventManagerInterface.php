<?php
/**
 * @file     EventManagerInterface.php
 * @folder   /libs/Event
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * Interface for the EventManager
 */

namespace Frogsystem2\Event;


interface EventManagerInterface
{
    /**
     * Trigger all listeners to an event.
     * @param string $event
     * @param mixed $target
     * @param array $parameters
     * @return ResponseCollection
     */
    public function trigger($event, $target = null, $parameters = array());

    /**
     * Attach an event-listener to an event.
     * @param string $event
     * @param callable $listener
     * @param int $priority
     * @return $this
     */
    public function attach($event, $listener, $priority = 0);

    /**
     * Get all events for which listeners are attached
     * @return array
     */
    public function getEvents();

    /**
     * Get all listeners for a given event.
     * @param string $event
     * @return array
     */
    public function getListeners($event);
}