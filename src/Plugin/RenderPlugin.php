<?php

namespace Spiffy\AsseticPackage\Plugin;

use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Framework\Application;
use Spiffy\Framework\ApplicationEvent;

class RenderPlugin implements Plugin
{
    /**
     * @param Manager $events
     * @return void
     */
    public function plug(Manager $events)
    {
        $events->on(Application::EVENT_RENDER, [$this, 'onRender'], 1000);
    }

    /**
     * @param ApplicationEvent $e
     */
    public function onRender(ApplicationEvent $e)
    {
        $app = $e->getApplication();
        $i = $app->getInjector();

        $service = $i->nvoke('spiffy.assetic.assetic-service');
        $service->load();
    }
}
