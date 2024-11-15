<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brands = [
            'AVON', 'BF GOODRICH', 'BRIDGESTONE', 'CONTINENTAL', 'COOPER TIRES',
            'DEBICA', 'DUNLOP', 'FORTUNE', 'GENERAL TIRE', 'GOODYEAR',
            'KORMORAN', 'KUMHO', 'MAXXIS', 'MICHELIN', 'NANKANG', 'NEXEN',
            'NOKIAN', 'OVATION', 'PETLAS', 'PIRELLI', 'RADAR', 'ROVELO',
            'SAVA', 'SEIBERLING', 'UNIROYAL', 'WESTLAKE', 'YOKOHAMA',
            'ZEETEX'
        ];

        foreach ($brands as $name) {
            $brand = new Brand();
            $brand->setName($name);
            $manager->persist($brand);
        }

        $manager->flush();
    }
}
