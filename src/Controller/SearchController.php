<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/games/search', name: 'app_games_search')]
    public function index(Request $request): Response
    {
        $query = $request->query->get('query');

        return $this->render('search/index.html.twig', [
            'query' => $query
        ]);
    }
}
