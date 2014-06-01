<?php

namespace Spiffy\AsseticPackage;

use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Mvc\MvcEvent;

class MvcRenderPlugin implements Plugin
{
    /**
     * @param Manager $events
     * @return void
     */
    public function plug(Manager $events)
    {
        $events->on(MvcEvent::EVENT_RENDER, [$this, 'onRender'], 1000);
    }

    /**
     * @param MvcEvent $e
     */
    public function onRender(MvcEvent $e)
    {
        $app = $e->getApplication();
        $i = $app->getInjector();

        $service = $i->nvoke('spiffy.assetic.assetic-service');
        $service->load();
    }
}
