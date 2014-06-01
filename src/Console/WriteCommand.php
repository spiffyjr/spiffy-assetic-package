<?php

namespace Spiffy\AsseticPackage\Command;

use Spiffy\AsseticPackage\Plugin\WriteAssetPlugin;
use Spiffy\Mvc\ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WriteCommand extends ConsoleCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('assetic:write')
            ->setDescription('Writes all assets to the filesystem');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $i = $this->getInjector();

        /** @var \Spiffy\Assetic\AsseticService $asseticService */
        $asseticService = $i->nvoke('spiffy.assetic.assetic-service');
        $asseticService->events()->plug(new WriteAssetPlugin($output));

        $assetManager = $asseticService->getAssetManager();
        $asseticService->load();

        $output->writeln(sprintf('Writing all assets.'));
        $output->writeln(sprintf('Debug mode is <comment>%s</comment>', $assetManager->isDebug() ? 'on' : 'off'));
        $output->writeln('');

        $asseticService->writeAssets(
            $i['spiffy.assetic-package']['output_dir'],
            $i['spiffy.assetic-package']['variables'],
            false
        );

        return 0;
    }
}
