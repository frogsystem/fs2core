<?php
/**
 * @file     EventListenerInterface.php
 * @folder   /libs/Event
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * Helper class to load all defined events
 */

namespace Frogsystem2\Event;


class EventLoader
{
    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * @param string $dir
     * @param string $namespace
     * @return array
     */
    public function loadEvents($dir, $namespace)
    {
        $dirScan = @scandir($dir);

        if($dirScan === false)
        {
            throw new \RuntimeException('Could not load Events.');
        }

        $events = array();

        foreach($dirScan as $file)
        {
            if($file === '.' || $file === '..')
            {
                continue;
            }
            elseif(is_dir($dir . DIRECTORY_SEPARATOR . $file))
            {
                $events += $this->loadEvents($dir . DIRECTORY_SEPARATOR . $file, $namespace . '\\' . $file);
            }
            elseif(substr($file, -4) === '.php')
            {
                $events[] = $namespace . '\\' . substr($file, 0, -4);
            }
        }

        return $events;
    }

    /**
     * @param array $events
     */
    public function attachEvents($events)
    {
        foreach($events as $eventClass)
        {
            /** @var EventListenerInterface $event */
            $event = new $eventClass();

            if($event instanceof EventListenerInterface)
            {
                $event->attach($this->getEventManager());
            }
        }
    }
}