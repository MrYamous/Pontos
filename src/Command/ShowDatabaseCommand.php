<?php

namespace Yamous\InspectDatabaseBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'database:show', aliases: ['db:show'])]
final class ShowDatabaseCommand extends Command
{
    public function __construct(public EntityManagerInterface $entityManager) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $connection = $this->entityManager->getConnection();
        $schemaManager = $connection->createSchemaManager();        
        $params = $connection->getParams();

        $io->section('Database Information');
        $io->definitionList(
            ['Database name' => $params['dbname'] ?? 'Unknown database'],
            ['Driver' => $params['driver'] ?? 'Unknown driver'],
            ['Server version' => $params['serverVersion'] ?? 'Unknown version'],
            ['Host' => $params['host'] ?? 'Unknown host'],
            ['Port' => $params['port'] ?? 'Unknown port'],
            ['Charset' => $params['charset'] ?? 'Unknown charset']
        );

        $io->section('Tables Information');

        $tables = $schemaManager->listTables();
        if (empty($tables)) {
            $io->block('No tables found in the database.');
            return Command::SUCCESS;
        }

        $io->table(['#', 'Name', 'Columns', 'Primary Key', 'Comment'], array_map(
        fn($table, $i) => [
            $i + 1,
            $table->getName(),
            count($table->getColumns()),
            implode(', ', $table->getPrimaryKey()->getColumns()),
            $table->getComment() ?? '—',
        ],
        $tables,
        array_keys($tables)
        ));

        return Command::SUCCESS;
    }
}