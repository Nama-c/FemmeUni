<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'chrisnama:entity:make',
    description: 'Crée ou met à jour une entité (utilise make:entity)',
)]
class ChrisnamaEntityMakeCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::OPTIONAL, 'Nom de la classe de l\'entité');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $arguments = [];

        if ($name = $input->getArgument('name')) {
            $arguments['name'] = $name;
        }

        $command = $this->getApplication()->find('make:entity');

        return $command->run(new ArrayInput($arguments), $output);
    }
}