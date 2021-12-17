<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tournoi;
use App\Entity\Evenement;
use App\Entity\User;
use App\Entity\Equipe;
use App\Entity\Matchjouer;
use App\Entity\Poulee;
use App\Entity\Tour;
class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tournoi Projet');
    }

    public function configureMenuItems(): iterable
    {
      //  yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Tournois', 'fas fa-list', Tournoi::class);
        yield MenuItem::linkToCrud('Evenement', 'fas fa-list', Evenement::class);
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Equipe', 'fas fa-list', Equipe::class);
        yield MenuItem::linkToCrud('Matchjouer', 'fas fa-list', Matchjouer::class);
        yield MenuItem::linkToCrud('Poulee', 'fas fa-list', Poulee::class);
        yield MenuItem::linkToCrud('Tour', 'fas fa-list', Tour::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
