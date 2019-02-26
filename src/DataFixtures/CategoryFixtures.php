<?php

namespace App\DataFixtures;

use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Category;

class CategoryFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ObjectManager $manager
     */
    private $manager;

    /**
     * @var int $entries
     */
    private $entries;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->entries = 100;

        $this->category();

        $this->manager->flush();
    }

    private function category(): void
    {
        $entityFixtures = new EntityFixtures();
        for ($i = 0; $i <= $this->entries; ++$i) {
            $this->manager->persist($entityFixtures->getCategory($this->entries));
        }
    }

    public function getOrder(): int
    {
        return 1;
    }
}
