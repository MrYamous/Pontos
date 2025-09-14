<?php

namespace Yamous\InspectDatabaseBundle\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Yamous\InspectDatabaseBundle\Command\ShowDatabaseCommand;
use Yamous\InspectDatabaseBundle\Command\ShowTableCommand;
use Yamous\InspectDatabaseBundle\Tests\Fixtures\TestKernel;

class InspectDatabaseBundleTest extends KernelTestCase
{
    use MicroKernelTrait;

    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    public function testServicesAreRegistered(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->assertTrue($container->has('yamous_inspect_database.show_database_command'));
        $this->assertTrue($container->has('yamous_inspect_database.show_table_command'));
    }

    public function testCommandsCanBeInstantiated(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $showDatabaseCommand = $container->get('yamous_inspect_database.show_database_command');
        $showTableCommand = $container->get('yamous_inspect_database.show_table_command');

        $this->assertInstanceOf(ShowDatabaseCommand::class, $showDatabaseCommand);
        $this->assertInstanceOf(ShowTableCommand::class, $showTableCommand);
    }
}