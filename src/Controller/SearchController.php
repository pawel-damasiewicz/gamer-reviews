<?php

namespace App\Controller;

use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/games/search', name: 'app_games_search')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $query = $request->query->get('query');

        $games = $entityManager->getRepository(Game::class)->findByName($query);

        return $this->render('search/index.html.twig', [
            'query' => $query,
            'games' => $games
        ]);
    }
}
