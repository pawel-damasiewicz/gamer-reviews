<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findTrending();

        return $this->render('home/index.html.twig', [
            'games' => $games
        ]);
    }
}

