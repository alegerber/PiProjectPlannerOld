<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var int
     */
    private $entrys;

    /**
     * @param ObjectManager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->entrys = 100;

        $this->category();

        $this->manager->flush();
    }

    private function category(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $category = new Category();
            $category->setName('category '.rand(0, $this->entrys));
            $category->setComponentLink('category'.rand(0, $this->entrys));

            $this->manager->persist($category);
        }
    }
}
