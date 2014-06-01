<?php

namespace Spiffy\AsseticPackage\Plugin;

use Spiffy\Assetic\Plugin\FilterLoaderPlugin as BaseFilterLoaderPlugin;
use Spiffy\Inject\Injector;
use Spiffy\Inject\InjectorUtils;

class FilterLoaderPlugin extends BaseFilterLoaderPlugin
{
    /**
     * @var Injector
     */
    protected $injector;

    /**
     * @param Injector $injector
     * @param array $filters
     */
    public function __construct(Injector $injector, array $filters)
    {
        $this->injector = $injector;
        parent::__construct($filters);
    }

    /**
     * {@inheritDoc}
     */
    protected function loadFilter($filter)
    {
        return InjectorUtils::get($this->injector, $filter);
    }
}
