<?php

namespace Yamous\InspectDatabaseBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'database:show', aliases: ['db:show'])]
final class ShowDatabaseCommand extends Command
{

    public function __construct(public EntityManagerInterface $entityManager) {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}