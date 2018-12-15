<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Interfaces\JsonFixture;
use App\Traits\JsonGenerator;

class CategoryFixtures extends Fixture implements JsonFixture
{
    
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var integer
     */
    private $entrys;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 100;
        
        $this->category();
        $this->manager->flush();
        

    }

    private function category()
    {
        for ($i = 0; $i <= $this->entrys; $i++){

            $category = new Category();
            $category->setName('category ' .rand(0, $this->entrys));
            $category->setComponentLink('category' . rand(0, $this->entrys));

            $category->setProjects($this->getJson(7, $this->entrys));
            $category->setComponents($this->getJson(7, $this->entrys));

            $this->manager->persist($category);
        }
    }
}
