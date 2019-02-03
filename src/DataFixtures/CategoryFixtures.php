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
            $name = 'category '.\mt_rand(0, $this->entrys);
            $category->setName($name);
            $category->setSlug(
                Slugger::slugify($name)
            );

            $this->manager->persist($category);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
