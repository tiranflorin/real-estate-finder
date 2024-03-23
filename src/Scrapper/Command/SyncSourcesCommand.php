<?php

namespace App\Scrapper\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'scrapper:sync-sources',
    description: 'Scrapes data from existing sources',
    hidden: false
)]
class SyncSourcesCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $sources = [
            'scrapper:lajumate',
            'scrapper:publi24',
            'scrapper:romimo',
        ];

        $io = new SymfonyStyle($input, $output);
        $io->progressStart(count($sources));

        foreach ($sources as $sourceName) {
            $io->info("Getting data from $sourceName ...");
            $commandInput = new ArrayInput([
                'command' => $sourceName
            ]);
            $returnCode = $this->getApplication()->doRun($commandInput, $output);
            $io->success("Finished $sourceName with output code: $returnCode");
            $io->newLine();
            $io->progressAdvance();
        }

        $io->progressFinish();

        return Command::SUCCESS;
    }
}
