<?php

declare(strict_types=1);

namespace Czechiaa\Bundle\CommunicationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CommunicationExtension extends Extension
{
    /**
     * @throws \Exception
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
