<?php
/**
 * @file     renderTemplate.php
 * @folder   /event/Core
 * @version  0.1
 * @author   Satans Krümelmonster
 *
 * render template core-events
 */

namespace Event\Core;

use Frogsystem2\Event\EventInterface;
use Frogsystem2\Event\EventListenerInterface;
use Frogsystem2\Event\EventManagerInterface;

class renderTemplate implements EventListenerInterface
{
    public function attach(EventManagerInterface $eventManager)
    {
        $eventManager->attach(\Frogsystem2::EVENT_RENDER, array($this, 'renderPage'));
    }

    public function renderPage(EventInterface $event)
    {
        /** @var \template $theTemplate */
        $theTemplate = $event->getTarget();

        $stringTemplate = $theTemplate->__toString();

        $mainTemplate = get_maintemplate($stringTemplate);

        $renderedTemplate = tpl_functions_init($mainTemplate);

        return $renderedTemplate;
    }
}