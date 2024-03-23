<?php

namespace App\Scrapper\Command\Sources;

use Facebook\WebDriver\Exception\TimeoutException;
use Symfony\Component\Panther\Client as PantherClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'scrapper:lajumate',
    description: 'Scrapes lajumate.ro posts',
    hidden: false
)]
class LaJumateCommand extends Command
{
    const PANTHER_SCREENSHOTS_DIR_PATH = '/var/www/symfony/var/panther-screenshots/';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $client = PantherClient::createChromeClient(
            '/var/www/symfony/drivers/chromedriver',
            [
                '--no-sandbox',
                '--disable-dev-shm-usage',
                '--headless'
            ],
            ['request_timeout_in_ms' => 20000000]
        );

        $response = $client->get('https://lajumate.ro/teren-intravilan-cheriu-bh-15037580.html');
        $response->takeScreenshot(LaJumateCommand::PANTHER_SCREENSHOTS_DIR_PATH . "lajumate-1.jpg");

        try {
            $client->waitFor('#onetrust-accept-btn-handler', 5);
        } catch (TimeoutException) {
            $output->writeln('Unable to find expected content.');
            return Command::FAILURE;
        }

        $crawler = $response->getCrawler();
        $crawler->selectButton('ACCEPT TOATE')->click();
        $client->wait(rand(1, 3));
        $client->refreshCrawler();

        $title = $crawler->filter("h1")->first()->text();
        $description = $crawler->filter("#description")->text();

        print_r([$title, $description]);

        return Command::SUCCESS;
    }
}
