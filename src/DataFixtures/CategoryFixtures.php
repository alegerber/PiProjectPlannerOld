<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Services\JsonGenerator;

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
     * @var JsonGenerator
     */
    private $jsonGenerator;

    /**
     * @param JsonArrayToArrayClasses
     */
    public function __construct(
        JsonGenerator $jsonGenerator
    ) {
        $this->jsonGenerator = $jsonGenerator;
    }

    /**
     * @param ObjectManager
     */
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 100;

        $this->category();

        $this->manager->flush();
    }

    private function category()
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $category = new Category();
            $category->setName('category '.rand(0, $this->entrys));
            $category->setComponentLink('category'.rand(0, $this->entrys));
            $category->setProjects($this->jsonGenerator->getJson(7, $this->entrys));
            $category->setComponents($this->jsonGenerator->getJson(7, $this->entrys));

            $this->manager->persist($category);
        }
    }
}
