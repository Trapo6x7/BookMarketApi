<?php

namespace App\Controller\Admin;

use App\Entity\Anounce;
use App\Entity\Article;
use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\OrderState;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
        // return $this->redirectToRoute('admin_user_index');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('FILROUGEBACKEND');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('BOOKMARKET');
        yield MenuItem::linkToCrud('User', 'fas fa-venus-mars', User::class);
        yield MenuItem::linkToCrud('Anounce', 'fas fa-briefcase', Anounce::class);
        yield MenuItem::linkToCrud('Article', 'fas fa-ship', Article::class);
        yield MenuItem::linkToCrud('Book', 'fas fa-user-tie', Book::class);
        yield MenuItem::linkToCrud('Order', 'fas fa-user-tie', Order::class);
        yield MenuItem::linkToCrud('OrderState', 'fas fa-user-tie', OrderState::class);;
        yield MenuItem::linkToCrud('Category', 'fas fa-user-tie', Category::class);
        yield MenuItem::linkToCrud('Author', 'fas fa-user-tie', Author::class);

    }
}
