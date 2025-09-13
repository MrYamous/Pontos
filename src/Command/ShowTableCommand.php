<?php

namespace Yamous\InspectDatabaseBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'table:show', aliases: ['tb:show'])]
final class ShowTableCommand extends Command
{
    public function __construct(public EntityManagerInterface $entityManager) {
        parent::__construct();
    }

    public function __invoke(
        InputInterface $input,
        OutputInterface $output,
        #[Argument] string $tableName): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $connection = $this->entityManager->getConnection();
        $schemaManager = $connection->createSchemaManager();

        $columns = $schemaManager->listTableDetails($tableName)->getColumns();

        $columnData = array_map(
            fn($column) => [
                $column->getName(),
                $column->getType()->getName(),
                $column->getUnsigned() ? 'Yes' : 'No',
                $column->getFixed() ? 'Yes' : 'No',
                $column->getLength() ?? '-',
                $column->getPrecision() ?? '-',
                $column->getScale() ?? '-',
                $column->getNotnull() ? 'No' : 'Yes',
                $column->getDefault() ?? '-',
                $column->getAutoincrement() ? 'Yes' : 'No',
                $column->getComment() ?? '-'
            ],
            $columns
        );

        $io->section('Columns Information');

        $io->table([
            'Name',
            'Type',
            'Unsigned',
            'Fixed',
            'Length',
            'Precision',
            'Scale',
            'Nullable',
            'Default',
            'Autoincrement',
            'Comment'
        ],
            $columnData
        );

        $io->section('Indexes Information');

        $indexes = $schemaManager->listTableIndexes($tableName);
        
        $indexData = array_map(
            fn($index) => [
                implode($index->getColumns()),
                $index->isUnique() ? 'Yes' : 'No',
                $index->isPrimary() ? 'Yes' : 'No',
            ],
            $indexes
        );
        usort($indexData, fn($a, $b) => ($b[2] === 'Yes') <=> ($a[2] === 'Yes'));

        $io->table([
            'Columns',
            'Unique',
            'Primary',
        ],
            $indexData
        );

        return Command::SUCCESS;
    }
}