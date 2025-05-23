<?php

namespace App\Command;

use App\Entity\Game;
use App\Entity\SteamApp;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:fetch-steam-apps',
    description: 'Fetch steam app ids, save them locally and assign app id to existing games.',
)]
class FetchSteamAppsCommand extends Command
{
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $response = $this->client->request(
            'GET',
            'https://api.steampowered.com/ISteamApps/GetAppList/v2/'
        );

        if ($response->getStatusCode() != 200) {
            $io->error(sprintf(
                "Steam '/ISteamApps/GetAppList/v2' returned invalid status code %s",
                $response->getStatusCode()
            ));
        }

        $io->note('Fetched steam app ids.');

        $steamApps = $response->toArray()['applist']['apps'];

        $io->note('Parsed steam app ids.');

        $progressBar = new ProgressBar($output, count($steamApps));
        $progressBar->start();

        $batchSize = 50;
        $batchIndex = 0;

        foreach ($steamApps as $app) {
            $batchIndex++;
            $steamApp = $this
                ->entityManager
                ->getRepository(SteamApp::class)
                ->findOneBy(['appId' => $app['appid']]);
            if (!$steamApp) {
                $steamApp = new SteamApp();
                $steamApp->setName($app['name']);
                $steamApp->setAppId($app['appid']);
                $this->entityManager->persist($steamApp);
            }

            $name = $app['name'];
            $game = $this->entityManager->getRepository(Game::class)->findOneBy(['name' => $name]);
            if ($game) {
                $io->block(strval($game));

                $game->setSteamAppId($app['appid']);
            }

            if ($batchIndex >= $batchSize) {
                $this->entityManager->flush();
            }

            $progressBar->advance();
        }

        $this->entityManager->flush();

        $io->success('Success!');

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
