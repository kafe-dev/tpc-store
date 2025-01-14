<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        // Create the ADMIN user
        $admin = new \App\Entity\User();
        $admin->setEmail('admin@gmail.com');
        $admin->setUsername('admin');
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin@123');
        $admin->setPassword($hashedPassword);
        $admin->setRoles((array)User::ROLE_ADMIN);
        $admin->setStatus(1);
        $manager->persist($admin);

        // Create the ADMIN user
        $adminUser = new \App\Entity\User();
        $adminUser->setEmail('manager@gmail.com');
        $adminUser->setUsername('manager');
        $hashedPassword = $this->passwordHasher->hashPassword($adminUser, 'adminuser@123');
        $adminUser->setPassword($hashedPassword);
        $adminUser->setRoles((array)User::ROLE_MANAGER);
        $adminUser->setStatus(1);
        $manager->persist($adminUser);

        // Create the CUSTOMER user
        $customer = new \App\Entity\User();
        $customer->setEmail('customer1@gmail.com');
        $customer->setUsername('customer1');
        $hashedPassword = $this->passwordHasher->hashPassword($customer, 'customer@123');
        $customer->setPassword($hashedPassword);
        $customer->setRoles((array)User::ROLE_USER);
        $customer->setStatus(1);
        $manager->persist($customer);

        // Create the CUSTOMER user
        $customer = new \App\Entity\User();
        $customer->setEmail('customer2@gmail.com');
        $customer->setUsername('customer2');
        $hashedPassword = $this->passwordHasher->hashPassword($customer, 'customer@123');
        $customer->setPassword($hashedPassword);
        $customer->setRoles((array)User::ROLE_USER);
        $customer->setStatus(0);
        $manager->persist($customer);


        $manager->flush();
    }
}
