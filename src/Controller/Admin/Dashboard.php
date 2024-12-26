<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class Dashboard.
 *
 * This controller handles all the actions for the app dashboard.
 */
#[Route('/admin', name: 'admin_dashboard_')]
class Dashboard extends BaseController
{
    /**
     * Action index.
     *
     * @return Response
     */
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig');
    }

}
