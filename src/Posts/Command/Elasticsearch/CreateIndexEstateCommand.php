<?php

namespace App\Posts\Command\Elasticsearch;

use Elastica\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;

#[AsCommand(
    name: 'elastic:create-index-real_estate',
    description: 'Creates a new ES index called <real_estate>.',
    aliases: ['es:create-real_estate'],
    hidden: false
)]
class CreateIndexEstateCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $logger = new ConsoleLogger($output);
        try {
            $elasticaClient = new Client(array(
                'host' => 'localhost',
                'port' => 9200
            ));
            $logger->info('Connected to ES');
            $output->writeln('Connected to ES');
        } catch (\Exception $e) {
            $logger->critical('Unable to connect to ES', ['exception_message' => $e->getMessage()]);
            $output->writeln('Unable to connect to ES' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
