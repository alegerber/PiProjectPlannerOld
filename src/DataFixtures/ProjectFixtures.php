<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;

class ProjectFixtures extends Fixture implements FixtureGroupInterface
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

        $this->project();

        $this->manager->flush();
    }

    public static function getGroups(): array
    {
        return ['run'];
    }

    private function project(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $project = new Project();
            $projectNumber = rand(0, $this->entrys);
            $project->setLink('project-'.$projectNumber);
            $project->setTitle('project '.$projectNumber);
            $project->setDescription('Some Random Text '.\mt_rand(0, $this->entrys));
            //$project->setImage(rand(0, $this->entrys));
            //$project->setCategories($this->jsonGenerator->getJson(7, $this->entrys));
            //$project->setTags($this->jsonGenerator->getJson(7, $this->entrys));
            //$project->setComponents($this->jsonGenerator->getJson(7, $this->entrys));

            $this->manager->persist($project);
        }
    }
}
