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
     * @var int $entrys
     */
    private $entrys;

    /**
     * @param ObjectManager $manager
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
            $name = 'category '.\random_int(0, $this->entrys);
            $category->setName($name);
            $category->setSlug(
                Slugger::slugify($name)
            );

            $this->manager->persist($category);
        }
    }

    public function getOrder(): int
    {
        return 1;
    }
}
