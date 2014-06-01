<?php

namespace Spiffy\AsseticPackage;

use Spiffy\Assetic\Twig\AsseticExtension;
use Spiffy\Inject\Injector;
use Spiffy\Mvc\AbstractMvcPackage;
use Spiffy\Mvc\Application;

class Package extends AbstractMvcPackage
{
    /**
     * @param Application $app
     */
    public function bootstrap(Application $app)
    {
        // Causes the assetic service to load before rendering. Laziest solution possible.
        $app->events()->plug(new MvcRenderPlugin());

        $this->prepareTwig($app->getInjector());
    }

    /**
     * @param Injector $i
     */
    private function prepareTwig(Injector $i)
    {
        $twig = $i->nvoke('twig');
        $asseticService = $i->nvoke('spiffy.assetic.assetic-service');

        $twig->addExtension(new AsseticExtension(
                $asseticService->getAssetFactory(),
                $i['assetic']['parsers'],
                $i['assetic']['functions']
            )
        );
    }
}
