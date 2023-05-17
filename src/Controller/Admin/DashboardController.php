<?php

namespace App\Controller\Admin;

use App\Entity\Game;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(GameCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('App');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Front');
        yield MenuItem::linkToRoute('Home', 'fa fa-home', 'app_homepage');
        yield MenuItem::section('Admin');
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-star');
        yield MenuItem::section('Games');
        yield MenuItem::linkToCrud('Games', 'fa fa-tags', Game::class);
    }
}
