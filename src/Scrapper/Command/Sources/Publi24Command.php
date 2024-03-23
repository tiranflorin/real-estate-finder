<?php

namespace App\Scrapper\Command\Sources;

use Facebook\WebDriver\Exception\TimeoutException;
use Symfony\Component\Panther\Client as PantherClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'scrapper:publi24',
    description: 'Scrapes publi24.ro posts',
    hidden: false
)]
class Publi24Command extends Command
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

        $response = $client->get('https://www.publi24.ro/anunturi/imobiliare/de-vanzare/terenuri/teren-intravilan/anunt/vand-teren-intravilan-varsolt-jud-salaj-2000mp/15387973354671g3253i1d847d0ii971.html');
        $response->takeScreenshot(Publi24Command::PANTHER_SCREENSHOTS_DIR_PATH . "publi24-1.jpg");

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

        $title = $crawler->filter("h1")->first()->text();
        $description = $crawler->filter(".article-detail")->text();

        print_r([$title, $description]);

        return Command::SUCCESS;
    }
}
