<?php

return [
    'spiffy.assetic.assetic-service' => 'Spiffy\AsseticPackage\AsseticServiceFactory',

    // plugins
    'spiffy.assetic.plugin.twig-loader-plugin' => [
        'Spiffy\Assetic\Plugin\TwigLoaderPlugin',
        ['@twig.environment', '$assetic[cache_dir]']
    ],
    'spiffy.assetic.plugin.asset-loader-plugin' => [
        'Spiffy\Assetic\Plugin\AssetLoaderPlugin',
        ['$assetic[assets]']
    ],
    'spiffy.assetic.plugin.directory-loader-plugin' => [
        'Spiffy\Assetic\Plugin\DirectoryLoaderPlugin',
        ['$assetic[directories]', '$assetic[cache_dir]']
    ],
    'spiffy.assetic-package.plugin.filter-loader-plugin' => 'Spiffy\AsseticPackage\Plugin\FilterLoaderPluginFactory',
];
