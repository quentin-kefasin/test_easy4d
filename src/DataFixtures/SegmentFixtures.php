<?php

namespace App\DataFixtures;

use App\Entity\Segment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SegmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $segments = ['Budget', 'Premium', 'Quality'];

        foreach ($segments as $name) {
            $segment = new Segment();
            $segment->setName($name);
            $manager->persist($segment);
        }

        $manager->flush();
    }
}
