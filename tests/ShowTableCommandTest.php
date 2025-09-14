<?php

namespace Yamous\InspectDatabaseBundle\Tests\Functional;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;
use Yamous\InspectDatabaseBundle\Tests\Fixtures\TestKernel;

class ShowTableCommandTest extends KernelTestCase
{
    private Connection $connection;
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $this->connection = self::getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getConnection();
    }

    protected function tearDown(): void
    {
        $this->cleanupTestTables();
        parent::tearDown();
    }

    public function testShowTableCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        
        $command = $application->find('table:show');
        $commandTester = new CommandTester($command);
        
        $commandTester->execute(['table-name' => 'user']);
        
        $commandTester->assertCommandIsSuccessful($commandTester->getDisplay());
    }

    public function testShowTableAliasCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        
        $command = $application->find('tb:show');
        $commandTester = new CommandTester($command);
        
        $commandTester->execute(['table-name' => 'user']);
        
        $commandTester->assertCommandIsSuccessful($commandTester->getDisplay());
    }

    public function testShowTableCommandContent(): void
    {
        $this->createTestTable();
        
        $application = new Application(self::$kernel);
        $command = $application->find('table:show');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['table-name' => 'test_users']);        
        $output = $commandTester->getDisplay();
        
        $this->assertStringContainsString('id', $output);
        $this->assertStringContainsString('name', $output);
        $this->assertStringContainsString('email', $output);
        $this->assertStringContainsString('created_at', $output);
        
        $this->assertStringContainsString('integer', $output);
        $this->assertStringContainsString('datetime', $output);
        
        $this->assertStringContainsStringIgnoringCase('100', $output);
    }

        private function createTestTable(): void
    {
        $sql = '
            CREATE TABLE IF NOT EXISTS test_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(100) NOT NULL,
                email VARCHAR(255) UNIQUE,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ';
        
        $this->connection->executeStatement($sql);
    }

    private function cleanupTestTables(): void
    {
        try {
            $this->connection->executeStatement('DROP TABLE IF EXISTS test_users');
        } catch (\Exception $e) {}
    }
}