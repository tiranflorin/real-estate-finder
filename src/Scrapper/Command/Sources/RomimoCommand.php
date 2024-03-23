<?php

namespace App\Scrapper\Command\Sources;

use Facebook\WebDriver\Exception\TimeoutException;
use Symfony\Component\Panther\Client as PantherClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'scrapper:romimo',
    description: 'Scrapes romimo.ro posts',
    hidden: false
)]
class RomimoCommand extends Command
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

        $response = $client->get('https://www.romimo.ro/anunturi/imobiliare/de-vanzare/terenuri/teren-intravilan/anunt/teren-intravilan/628e487g0eh0709426h84he0565hh7f6.html');
        $response->takeScreenshot(RomimoCommand::PANTHER_SCREENSHOTS_DIR_PATH . "romimo-1.jpg");

        try {
            $client->waitFor('.cl-consent__inner', 5);
        } catch (TimeoutException) {
            $output->writeln('Unable to find expected content.');
            return Command::FAILURE;
        }

        $crawler = $response->getCrawler();
        $link = $crawler->filter('#cl-consent > div.cl-consent__inner > div.cl-consent-popup.cl-consent-popup--main.cl-consent-visible > div.cl-consent__buttons > a:nth-child(2)')->link();
        $client->click($link);
        $client->wait(rand(1, 3));
        $client->refreshCrawler();
        $response->takeScreenshot(RomimoCommand::PANTHER_SCREENSHOTS_DIR_PATH . "romimo-2.jpg");

        $title = $crawler->filter("h1")->first()->text();
        $description = $crawler->filter(".article-detail")->text();

        print_r([$title, $description]);

        return Command::SUCCESS;
    }
}
