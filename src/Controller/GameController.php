<?php

namespace App\Controller;

use App\Entity\Review;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class GameController extends AbstractController
{
    #[Route('/game/{id}', name: 'app_game_show')]
    public function show(int $id, GameRepository $gameRepository): Response
    {
        $game = $gameRepository->findOneBy(['id' => $id]);

        return $this->render('game/show.html.twig', [
            'game' => $game,
            'score' => $game->getReviews()->reduce(
                fn($sum, Review $review) => $sum + $review->getRating()
            ) / $game->getReviews()->count(),
        ]);
    }
}
