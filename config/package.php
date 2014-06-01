<?php

return [
    'assetic' => [
        'debug' => false,
        'autoload' => false,
        'root_dir' => './',
        'cache_dir' => 'cache/assetic',
        'output_dir' => 'public',
        'assets' => [],
        'filters' => [
            'cssmin' => 'Assetic\Filter\CssMinFilter',
            'jsmin' => 'Assetic\Filter\JSMinFilter',
        ],
        'filter_options' => [
            'less' => [
                'node_bin' => '/usr/bin/node',
                'node_paths' => ['/usr/lib/node_modules'],
                'load_paths' => [],
            ]
        ],
        'directories' => [],
        'functions' => [],
        'variables' => [],
        'parsers' => [
            'javascripts' => ['tag' => 'javascripts', 'output' => 'js/*.js'],
            'stylesheets' => ['tag' => 'stylesheets', 'output' => 'css/*.css'],
            'image' => ['tag' => 'image', 'output' => 'image/*', 'single' => true],
        ],
        'console_plugins' => [
            'directory_loader' => 'spiffy.assetic.plugin.directory-loader-plugin',
            'twig_loader' => 'spiffy.assetic.plugin.twig-loader-plugin'
        ],
        'plugins' => [
            'asset_loader' => 'spiffy.assetic.plugin.asset-loader-plugin',
            'filter_loader' => 'spiffy.assetic-package.plugin.filter-loader-plugin',
        ],
    ],
];
