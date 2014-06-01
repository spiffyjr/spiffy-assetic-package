<?php

namespace Spiffy\AsseticPackage\Plugin;

use Spiffy\Assetic\Plugin\FilterLoaderPlugin;
use Spiffy\Inject\Injector;
use Spiffy\Inject\InjectorUtils;
use Spiffy\Inject\ServiceFactory;

class FilterLoaderPluginFactory implements ServiceFactory
{
    /**
     * @param Injector $i
     * @return mixed
     */
    public function createService(Injector $i)
    {
        $filters = $i['assetic']['filters'];

        foreach ($filters as &$filter) {
            $filter = InjectorUtils::get($i, $filter);
        }

        return new FilterLoaderPlugin($filters);
    }
}
