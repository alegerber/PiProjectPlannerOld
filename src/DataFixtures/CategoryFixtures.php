<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends ParentFixtures
{

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 20;
        
        $this->category();
        $this->manager->flush();
        

    }

    private function category()
    {
        for ($i = 0; $i <= $this->entrys; $i++){

            $category = new Category();
            $category->setName('category ' .rand(0, $this->entrys));
            $category->setComponentLink('category' . rand(0, $this->entrys));

            $category->setProject($this->getJson(7));
            $category->setComponent($this->getJson(7));

            $this->manager->persist($category);
        }
    }
}
