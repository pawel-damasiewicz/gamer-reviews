<?php

namespace App\Controller\Api;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/api/game', name: 'app_api_game')]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findAll();

        return $this->json($this->transformGames($games));
    }

    private function transformGames(array $games): array
    {
        $result = [];
        foreach ($games as $game) {
            $result []= $this->transformGame($game);
        }

        return $result;
    }

    private function transformGame(Game $game): array
    {
        return [
            'id' => $game->getId(),
            'name' => $game->getName(),
        ];
    }
}
