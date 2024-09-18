<?php

namespace Yamous\InspectDatabaseBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

final class InspectDatabaseBundle extends AbstractBundle
{
    public function boot(): void
    {
        //dump($this->container->getParameter('doctrine.default_connection'));
        //die();
        //$this->container->getParameter('doctrine.default_connection');
        
    }

    public function prependExtension(ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        $loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__.'/Resources/config'));
        $loader->load('services.xml');
    }
}