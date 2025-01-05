<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {

        if ($user->getStatus() === 0) {
            throw new CustomUserMessageAccountStatusException('Tài khoản của bạn chưa được kích hoạt.');
        }

        if ($user->getStatus() === 2) {
            throw new CustomUserMessageAccountStatusException('Tài khoản của bạn đã bị khóa.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {

    }
}
