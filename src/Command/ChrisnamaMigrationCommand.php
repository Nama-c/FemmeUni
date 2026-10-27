<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'chrisnama:migration',
    description: 'Crée la migration puis l\'exécute',
)]
class ChrisnamaMigrationCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $application = $this->getApplication();

        // 1. Création de la migration
        $make = $application->find('make:migration');
        $code = $make->run(new ArrayInput([]), $output);

        if (Command::SUCCESS !== $code) {
            $io->error('Aucune migration créée (aucun changement détecté, ou erreur).');

            return Command::FAILURE;
        }

        // 2. Exécution (sans question de confirmation)
        $migrateInput = new ArrayInput([]);
        $migrateInput->setInteractive(false);

        $migrate = $application->find('doctrine:migrations:migrate');
        $code = $migrate->run($migrateInput, $output);

        if (Command::SUCCESS !== $code) {
            $io->error('La migration a échoué.');

            return Command::FAILURE;
        }

        $io->success('Migration créée et exécutée.');

        return Command::SUCCESS;
    }
}