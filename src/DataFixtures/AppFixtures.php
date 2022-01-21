<?php

namespace App\DataFixtures;

use App\Factory\PostFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        PostFactory::createOne([
            'content' => 'This content uses **markdown** inside!'
        ]);
        PostFactory::createMany(25);
    }
}
