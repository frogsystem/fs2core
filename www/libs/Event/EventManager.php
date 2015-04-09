<?php
/**
 * @file     EventManager.php
 * @folder   /libs/Event
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * Implementation of Frogsystem2\Event\EventManagerInterface
 */


namespace Frogsystem2\Event;


class EventManager implements EventManagerInterface
{
    /**
     * @var \SplPriorityQueue[]
     */
    protected $eventListener = array();

    /**
     * {@inheritdoc}
     */
    public function trigger($event, $target = null, $parameters = array())
    {
        $eventObject = new Event();
        $eventObject->setName($event)
            ->setTarget($target)
            ->setParameters($parameters);

        $resultList = new ResponseCollection();

        foreach($this->getListeners($event) as $listener)
        {
            $resultList->push(call_user_func($listener, $eventObject));

            if($eventObject->propagationStopped())
            {
                $resultList->setStopped(true);
                break;
            }
        }

        return $resultList;
    }

    /**
     * {@inheritdoc}
     */
    public function attach($event, $listener, $priority = 0)
    {
        if(!is_callable($listener))
        {
            throw new \BadMethodCallException('listener is not callable');
        }

        if(!isset($this->eventListener[$event]))
        {
            $this->eventListener[$event] = new \SplPriorityQueue();
            $this->eventListener[$event]->setExtractFlags(\SplPriorityQueue::EXTR_DATA);
        }

        $this->eventListener[$event]->insert($listener, $priority);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return array_keys($this->eventListener);
    }

    /**
     * {@inheritdoc}
     */
    public function getListeners($event)
    {
        if(isset($this->eventListener[$event]))
        {
            $listeners = array();

            foreach($this->eventListener[$event] as $listener)
            {
                $listeners[] = $listener;
            }

            return $listeners;
        }

        return array();
    }

    /**
     * Determine whether there are listeners for a given event or not
     * @param string $event
     * @return bool
     */
    public function hasListeners($event)
    {
        return isset($this->eventListener[$event]);
    }

}