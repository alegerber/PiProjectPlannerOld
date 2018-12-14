<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Picture;

class PictureFixtures extends ParentFixtures
{

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 100;
        
        $this->picture();
        $this->manager->flush();
        

    }

    private function picture()
    {
        for ($i = 0; $i <= $this->entrys; $i++){
            $picture = new Picture();
            $picture->setUrl('/files/pictures/pic' . rand(0, $this->entrys) . '.jpg');
            $picture->setTitle('picture ' . rand(0, $this->entrys));
            $picture->setDescription('Some Random Text ' . rand(0, $this->entrys));
            $picture->setTags($this->getJson(7));
    
            $this->manager->persist($picture);
        }
    }
}