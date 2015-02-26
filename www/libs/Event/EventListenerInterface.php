<?php
/**
 * @file     EventListenerInterface.php
 * @folder   /libs/Event
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * Interface for an EventListener
 */
namespace Frogsystem2\Event;


interface EventListenerInterface
{
    public function attach(EventManagerInterface $eventManager);
}