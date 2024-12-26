<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Class Security.
 *
 * This controller handles all the security actions.
 */
#[Route('/admin/security', name: 'admin_security_')]
class Security extends BaseController
{
    /**
     * Action login.
     *
     * This action is used to handle the login request,
     * and displays the login page.
     *
     * @return Response
     */
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('admin/security/login.html.twig');
    }

}
