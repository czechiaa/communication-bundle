<?php

declare(strict_types=1);

namespace Czechiaa\Bundle\CommunicationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const string BUNDLE = 'communication_bundle';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::BUNDLE);
    }
}
