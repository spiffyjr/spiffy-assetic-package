<?php

namespace Spiffy\AsseticPackage;

use Spiffy\Assetic\AsseticService;
use Spiffy\Inject\Injector;
use Spiffy\Inject\InjectorUtils;
use Spiffy\Inject\ServiceFactory;

class AsseticServiceFactory implements ServiceFactory
{
    /**
     * @param Injector $i
     * @return AsseticService
     */
    public function createService(Injector $i)
    {
        $service = new AsseticService($i['assetic']['root_dir'], $_ENV['debug']);
        $this->injectPlugins($i, $service, $i['assetic']['plugins']);

        return $service;
    }

    /**
     * @param Injector $i
     * @param AsseticService $service
     * @param array $plugins
     */
    protected function injectPlugins(Injector $i, AsseticService $service, array $plugins)
    {
        foreach ($plugins as $plugin) {
            if (empty($plugin)) {
                continue;
            }

            $service->events()->plug(InjectorUtils::get($i, $plugin));
        }
    }
}
