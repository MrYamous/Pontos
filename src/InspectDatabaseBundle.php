<?php

namespace Yamous\InspectDatabaseBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Yamous\InspectDatabaseBundle\Command\ShowDatabaseCommand;
use Yamous\InspectDatabaseBundle\Command\ShowTableCommand;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

final class InspectDatabaseBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('Resources/config/services.xml');

        $container->services()
            ->set('yamous_inspect_database.show_database_command', ShowDatabaseCommand::class)
            ->args([
                service('doctrine.orm.default_entity_manager'),
            ])
            ->tag('console.command')
            ->set('yamous_inspect_database.show_table_command', ShowTableCommand::class)
            ->args([
                service('doctrine.orm.default_entity_manager'),
            ])
            ->tag('console.command');
    }
}