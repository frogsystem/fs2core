<?php
/**
 * @file     StartUp.php
 * @folder   /event/Core
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * startup core-events
 */


namespace Event\Core;


use Frogsystem2\Event\EventInterface;
use Frogsystem2\Event\EventListenerInterface;
use Frogsystem2\Event\EventManagerInterface;

class StartUp implements EventListenerInterface
{
    public function attach(EventManagerInterface $eventManager)
    {
        $eventManager->attach(\Frogsystem2::EVENT_STARTUP, array($this, 'connectToDatabase'), 10)
            ->attach(\Frogsystem2::EVENT_STARTUP, array($this, 'setUpConfig'), 5);
    }

    public function connectToDatabase(EventInterface $event)
    {
        /** @var \GlobalData $FD */
        $FD = $event->getTarget();

        try
        {
            $FD->connect();
        }
        catch(\Exception $e)
        {
            $event->stopPropagation();

            return $e;
        }

        return null;
    }

    public function setUpConfig(EventInterface $event)
    {
        /** @var \GlobalData $FD */
        $FD = $event->getTarget();

        $FD->startup();
    }
}