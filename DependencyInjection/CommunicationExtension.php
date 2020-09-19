<?php

namespace Czechiaa\Bundle\CommunicationBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class CommunicationExtension
 * @package Czechiaa\Bundle\CommunicationBundle\DependencyInjection
 */
class CommunicationExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @return void
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(Configuration::BUNDLE, $config);

        $fileLocator = new FileLocator(__DIR__ . '/../Resources/config');

        $yamlLoader = new YamlFileLoader($container, $fileLocator);

        $yamlLoader->load('services.yaml');
    }
}
