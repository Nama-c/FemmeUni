<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'chrisnama:db:create',
    description: 'Supprime la base de données si elle existe, puis la recrée',
)]
class ChrisnamaDbCreateCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (!$io->confirm('La base va être supprimée avec toutes ses données. Continuer ?', false)) {
            $io->warning('Opération annulée.');

            return Command::SUCCESS;
        }

        $application = $this->getApplication();

        // 1. Suppression (sans erreur si la base n'existe pas)
        $drop = $application->find('doctrine:database:drop');
        $code = $drop->run(new ArrayInput(['--if-exists' => true, '--force' => true]), $output);

        if (Command::SUCCESS !== $code) {
            $io->error('Impossible de supprimer la base. Vérifie qu\'aucune connexion (pgAdmin, serveur) ne l\'utilise.');

            return Command::FAILURE;
        }

        // 2. Création
        $create = $application->find('doctrine:database:create');
        $code = $create->run(new ArrayInput([]), $output);

        if (Command::SUCCESS !== $code) {
            $io->error('Impossible de créer la base.');

            return Command::FAILURE;
        }

        $io->success('Base de données recréée.');

        return Command::SUCCESS;
    }
}