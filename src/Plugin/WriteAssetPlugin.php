<?php

namespace Spiffy\AsseticPackage\Plugin;

use Spiffy\Assetic\AsseticService;
use Spiffy\Event\Event;
use Spiffy\Event\Manager;
use Spiffy\Event\Plugin;
use Symfony\Component\Console\Output\OutputInterface;

class WriteAssetPlugin implements Plugin
{
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param Manager $events
     * @return void
     */
    public function plug(Manager $events)
    {
        $events->on(AsseticService::EVENT_DUMP_DIR, [$this, 'onDumpDir']);
        $events->on(AsseticService::EVENT_DUMP_TARGET, [$this, 'onDumpTarget']);
        $events->on(AsseticService::EVENT_DUMP_ASSET, [$this, 'onDumpAsset']);
        $events->on(AsseticService::EVENT_WATCH_ERROR, [$this, 'onWatchError']);
    }

    /**
     * @param Event $e
     */
    public function onDumpDir(Event $e)
    {
        $dir = $e->getTarget();
        $output = $this->output;

        $output->writeln(sprintf('<comment>%s</comment> <info>[dir+]</info> %s', date('H:i:s'), $dir));
    }

    /**
     * @param Event $e
     */
    public function onDumpTarget(Event $e)
    {
        $target = $e->getTarget();
        $output = $this->output;

        $output->writeln(sprintf('<comment>%s</comment> <info>[file+]</info> %s', date('H:i:s'), $target));
    }

    /**
     * @param Event $e
     */
    public function onDumpAsset(Event $e)
    {
        /** @var \Assetic\Asset\AssetInterface $asset */
        $asset = $e->getTarget();
        $root = $asset->getSourceRoot();
        $path = $asset->getSourcePath();
        $output = $this->output;

        $output->writeln(sprintf('        <info>%s/%s</info>', $root ?: '[unknown root]', $path ?: '[unknown path]'));
    }

    /**
     * @param Event $e
     */
    public function onWatchError(Event $e)
    {
        $output = $this->output;
        $output->writeln(sprintf('<error>[error] %s</error>', $e->getTarget()->getException()));
    }
}
