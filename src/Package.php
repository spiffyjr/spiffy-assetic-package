<?php

namespace Spiffy\AsseticPackage;

use Spiffy\Assetic\Twig\AsseticExtension;
use Spiffy\Framework\AbstractPackage;
use Spiffy\Framework\Application;
use Spiffy\Framework\ConsoleApplication;
use Spiffy\Inject\Injector;
use Spiffy\Inject\InjectorUtils;

class Package extends AbstractPackage
{
    /**
     * {@inheritDoc}
     */
    public function bootstrap(Application $app)
    {
        // Causes the assetic service to load before rendering. Laziest solution possible.
        $app->events()->plug(new Plugin\RenderPlugin());

        $this->prepareTwig($app->getInjector());
    }

    /**
     * {@inheritDoc}
     */
    public function bootstrapConsole(ConsoleApplication $console)
    {
        $i = $console->getInjector();

        /** @var \Spiffy\Assetic\AsseticService $asseticService */
        $asseticService = $i->nvoke('spiffy.assetic.assetic-service');

        foreach ($i['assetic']['console_plugins'] as $plugin) {
            $asseticService->events()->plug(InjectorUtils::get($i, $plugin));
        }

        parent::bootstrapConsole($console);
    }

    /**
     * @param Injector $i
     */
    private function prepareTwig(Injector $i)
    {
        $twig = $i->nvoke('twig.environment');
        $asseticService = $i->nvoke('spiffy.assetic.assetic-service');

        $twig->addExtension(new AsseticExtension(
                $asseticService->getAssetFactory(),
                $i['assetic']['parsers'],
                $i['assetic']['functions']
            )
        );
    }
}
