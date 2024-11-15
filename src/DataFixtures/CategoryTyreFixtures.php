<?php

namespace App\DataFixtures;

use App\Entity\CategoryTyre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryTyreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryTyres = ['AUTO', 'AGRICOLE', 'MOTO QUAD LOISIRS'];

        foreach ($categoryTyres as $name) {
            $categoryTyre = new CategoryTyre();
            $categoryTyre->setName($name);
            $manager->persist($categoryTyre);
        }

        $manager->flush();
    }
}
