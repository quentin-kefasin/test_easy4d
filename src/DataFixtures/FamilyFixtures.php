<?php

namespace App\DataFixtures;

use App\Entity\Family;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FamilyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $familys = [
            '4x4 4saisons', '4x4 ete', '4x4 hiver', 'camionnette ete',
            'camionnette hiver', 'Moto Cross', 'Tourisme 4saisons',
            'Tourisme collection', 'Tourisme competition', 'Tourisme ete',
            'Tourisme hiver', 'tracteur'
        ];

        foreach ($familys as $name) {
            $family = new Family();
            $family->setName($name);
            $manager->persist($family);
        }

        $manager->flush();
    }
}
