<?php

namespace Yamous\InspectDatabaseBundle\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'database:show', aliases: ['db:show'])]
final class ShowDatabaseCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }

    private function getDoctrineConnection(Connection $connection): Connection
    {
        return $connection;
    }
}