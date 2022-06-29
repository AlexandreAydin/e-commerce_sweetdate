<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Categry;
use App\Entity\Header;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
         return $this->render('admin/dasboard.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        //  $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OrderCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('AlrConseil');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-list', Categry::class);
        yield MenuItem::linkToCrud('Produits', 'fa fa-tag', Product::class);
        yield MenuItem::linkToCrud('Transport', 'fa fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Headers', 'fa fa-desktop', Header::class);
    }
}

