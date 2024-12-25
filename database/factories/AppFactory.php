<?php

declare(strict_types=1);

namespace Database\Factory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFactory extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        //
    }

}
