<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundle;
/**
 * Class Security.
 *
 * This controller handles all the security actions for user.
 */
#[Route('/security', name: 'app_security_')]
class Security extends BaseController
{
    /**
     * Action login.
     *
     * This action is used to handle the login request,
     * and displays the login page.
     *
     * @param AuthenticationUtils $authenticationUtils
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
            if ($this->isGranted('ROLE_USER')) {
                return $this->redirectToRoute('app_home_index');
            }
        }
        $title = "Đăng nhập";
        return $this->render('home/security/login.html.twig', [
            'title' => $title,
            'error' => $customErrorMessage,
        ]);
    }
    /**
     * Action logout.
     *
     * This action is used to handle the logout request
     */
    #[Route('/logout', name: 'logout')]
    public function logout(SecurityBundle $security): Response
    {
        return $security->logout();
    }
    /**
     * Action register.
     *
     * This action is used to handle the login request
     * and display the register page.
     */
    #[Route('/register', name: 'register')]
    public function register(SecurityBundle $security): Response
    {
        $title = "Đăng nhập";
        return $this->render('home/security/register.html.twig', [
            'title' => $title,
        ]);
    }

    /**
     * Action profile.
     *
     * This action is used to handle the user request
     * and display the profile page.
     */
    #[Route('/profile', name: 'profile')]
    public function profile(SecurityBundle $security): Response
    {
        if ($this->getUser()) {
            $user = $this->getUser();
        }else{
            return $this->redirectToRoute('app_security_login');
        }
        $title = "Thông tin";
        return $this->render('home/security/profile.html.twig', [
            'title' => $title,
            'user' => $user,
        ]);
    }

}
