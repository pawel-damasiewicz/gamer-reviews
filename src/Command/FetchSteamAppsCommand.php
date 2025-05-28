<?php

namespace App\Command;

use App\Entity\Game;
use App\Entity\SteamApp;
use ArrayIterator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:fetch-steam-apps',
    description: 'Fetch steam app ids, save them locally and assign app id to existing games.',
)]
class FetchSteamAppsCommand extends Command
{
    public function __construct(
        private HttpClientInterface $client,
        private EntityManagerInterface $entityManager,
        private CacheInterface $cache
    ) {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $appsArray = $this->cache->get(
            'get-app-list-v2',
            function (ItemInterface $item) use ($io): array {
                $item->expiresAfter(3600);

                $response = $this->client->request(
                    'GET',
                    'https://api.steampowered.com/ISteamApps/GetAppList/v2/'
                );
                $io->note('Fetched steam app ids.');

                if ($response->getStatusCode() != 200) {
                    $io->error(sprintf(
                        "Steam '/ISteamApps/GetAppList/v2' returned invalid status code %s",
                        $response->getStatusCode()
                    ));
                }

                return $response->toArray()['applist']['apps'];
            }
        );

        $steamApps = new ArrayIterator($appsArray);
        $io->note('Parsed steam app ids.');

        $io->progressStart($steamApps->count());

        $batchSize = 100;
        $batchIndex = 0;

        foreach ($steamApps as $app) {
            $game = $this->entityManager->getRepository(Game::class)->findOneBy(['name' => $app['name']]);
            if ($game) {
                $io->block(strval($game));

                $game->setSteamAppId($app['appid']);
            }

            $io->progressAdvance();

            $batchIndex++;
            if (($batchIndex % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $io->progressFinish();
        $io->success('Success!');

        return Command::SUCCESS;
    }
}
