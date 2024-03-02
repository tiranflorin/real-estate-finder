<?php

namespace App\Scrapper\Command;

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
            ['request_timeout_in_ms'=>20000000]
        );

        $response = $client->get("https://www.publi24.ro/anunturi/imobiliare/de-vanzare/terenuri/teren-intravilan/anunt/vand-teren-intravilan-varsolt-jud-salaj-2000mp/15387973354671g3253i1d847d0ii971.html");
        $response->takeScreenshot(Publi24Command::PANTHER_SCREENSHOTS_DIR_PATH . "publi24-1.jpg");

        $titles = $response->getCrawler()->filter("h2")->each(function ($node) {
            return trim($node->text()) . PHP_EOL;
        });

        $paragraphs = $response->getCrawler()->filter("p")->each(function ($node) {
            return trim($node->text()) . PHP_EOL;
        });

        // Use the array_map to bind the arrays together into one array
        $data = array_map(function ($title, $paragraph) {
            $new = array(
                "title" => trim($title),
                "paragraph" => trim($paragraph)
            );
            return $new;
        }, $titles, $paragraphs);

        print_r($data);

        return Command::SUCCESS;
    }
}
