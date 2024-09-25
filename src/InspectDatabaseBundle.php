<?php

namespace Yamous\InspectDatabaseBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Yamous\InspectDatabaseBundle\Command\ShowDatabaseCommand;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

final class InspectDatabaseBundle extends AbstractBundle
{
    public function boot(): void
    {
        dump($this->container->get('doctrine.orm.default_entity_manager'));
        //dump($this->container->getParameter('doctrine'));
        die();
        //$this->container->getParameter('doctrine.default_connection');
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('Resources/config/services.xml');

        $container->services()
            ->set('yamous_inspect_database.show_database_command', ShowDatabaseCommand::class)
                ->args([service('doctrine')]);

        //$definition = $builder->getDefinition('yamous_inspect_database.show_database_command');
        //$definition->setArgument(0, $builder->get('doctrine.orm.default_entity_manager'));
        //$definition->setArgument(0, $builder->getParameter('doctrine.default_connection'));
    }

    public function prependExtension(ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        //$loader = new XmlFileLoader($containerBuilder, new FileLocator(__DIR__.'/Resources/config'));
        //$loader->load('services.xml');
    }
}