<?php

namespace Czechiaa\Bundle\CommunicationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Czechiaa\Bundle\CommunicationBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    public const BUNDLE = 'communication_bundle';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder(self::BUNDLE);
    }
}
