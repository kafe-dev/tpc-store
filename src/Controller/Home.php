<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class Home.
 *
 * This is the default controller for this application.
 */
#[Route('/', name: 'app_home_')]
class Home extends BaseController
{
    /**
     * Action index.
     *
     * @return Response
     */
    #[Route(name: 'index')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

}
