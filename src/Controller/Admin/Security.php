<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $customErrorMessage = null;

        if ($error) {
            $errorMessage = $error->getMessage();
            if($errorMessage == 'Tên đăng nhập không tồn tại trong hệ thống!'){
                $customErrorMessage = 'Tên đăng nhập không tồn tại trong hệ thống!';
            }else{
                // Check the type of error
                $customErrorMessage = match (get_class($error)) {
                    'Symfony\Component\Security\Core\Exception\BadCredentialsException' => 'Tài khoản hoặc mật khẩu không đúng, vui lòng thử lại!',
                    'Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException' => $error->getMessage(),
                    'Symfony\Component\Security\Core\Exception\TooManyLoginAttemptsAuthenticationException' => 'Đăng nhập sai quá số lần cho phép!',
                    default => 'Sai thông tin đăng nhập, vui lòng thử lại!',
                };
            }

        }
        if ($this->getUser()) {
            // Check user ROLE to redirect to correct path
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_MANAGER')) {
                return $this->redirectToRoute('admin_dashboard_index');
            }

            if ($this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('app_home_index');
            }
        }
        $title = "Đăng nhập";
        return $this->render('admin/security/login.html.twig', [
            'title' => $title,
            'error' => $customErrorMessage,
        ]);
    }
    /**
     * Action login.
     *
     * This action is used to handle the login request
     * and display the login page.
     */
    #[Route('/logout', name: 'logout')]
    public function logout(\Symfony\Bundle\SecurityBundle\Security $security): Response
    {
        return $security->logout();
    }

}
