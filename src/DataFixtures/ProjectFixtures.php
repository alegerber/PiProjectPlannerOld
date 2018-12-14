<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;

class ProjectFixtures extends ParentFixtures
{


    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->entrys = 100;
        
        $this->project();
        $this->manager->flush();
        
    }


    private function project()
    {
        for ($i = 0; $i <= $this->entrys; $i++){

            $project = new Project();
            $project->setCategories(rand(0, $this->entrys));
            $project->setLink('project' . rand(0, $this->entrys));
            $project->setTitle('project ' . rand(0, $this->entrys));
            $project->setDescription('Some Random Text ' . rand(0, $this->entrys));
            $project->setPicture(rand(0, $this->entrys));
            $project->setTags($this->getJson(7));
            $project->setComponents($this->getJson(7));
    
            $this->manager->persist($project);
        }
    }
}
