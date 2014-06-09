<?php

namespace Spiffy\AsseticPackage\Plugin;

use Spiffy\Assetic\AsseticService;
use Spiffy\Event\Event;
use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Spiffy\Package\PackageManager;

final class ResolveAliasPlugin implements Plugin
{
    private $packageManager;

    /**
     * @param PackageManager $packageManager
     */
    public function __construct(PackageManager $packageManager)
    {
        $this->packageManager = $packageManager;
    }

    /**
     * {@inheritDoc}
     */
    public function plug(Manager $events)
    {
        $events->on(AsseticService::EVENT_RESOLVE_ALIAS, [$this, 'onResolveAlias']);
    }

    /**
     * @param Event $e
     * @return string
     */
    public function onResolveAlias(Event $e)
    {
        $input = $e->getTarget();

        if ('@' != $input[0] || false == strpos($input, '/')) {
            return;
        }

        $package = substr($input, 1);
        if (false !== $pos = strpos($package, '/')) {
            $package = substr($package, 0, $pos);
        }
        $path = $this->packageManager->getPath($package);

        if (!$path) {
            return;
        }

        $e->setTarget(str_replace('@' . $package, $path, $input));
    }
}
