<?php

namespace Spiffy\AsseticPackage\Command;

use Spiffy\AsseticPackage\Plugin\WriteAssetPlugin;
use Spiffy\Inject\InjectorAware;
use Spiffy\Inject\InjectorAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WatchCommand extends Command implements InjectorAware
{
    use InjectorAwareTrait;

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('assetic:watch')
            ->setDescription('Watches all assets and continually writes updates to the filesystem');
    }

    /**
     * {@inheritDoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $i = $this->getInjector();

        /** @var \Spiffy\Assetic\AsseticService $asseticService */
        $asseticService = $i->nvoke('spiffy.assetic.assetic-service');
        $asseticService->events()->plug(new WriteAssetPlugin($output));

        $assetManager = $asseticService->getAssetManager();
        $asseticService->load();

        $output->writeln(sprintf('Watching all assets.'));
        $output->writeln(sprintf('Debug mode is <comment>%s</comment>', $assetManager->isDebug() ? 'on' : 'off'));
        $output->writeln('');

        $asseticService->watchAssets(
            $i['assetic']['output_dir'],
            $i['assetic']['variables'],
            false
        );

        return 0;
    }
}
