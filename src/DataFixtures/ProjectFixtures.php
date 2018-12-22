<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Project;
use App\Services\JsonGenerator;

class ProjectFixtures extends Fixture
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

        $this->project();

        $this->manager->flush();
    }

    private function project()
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $project = new Project();
            $projectNumber = rand(0, $this->entrys);
            $project->setLink('project-'.$projectNumber);
            $project->setTitle('project '.$projectNumber);
            $project->setDescription('Some Random Text '.rand(0, $this->entrys));
            $project->setPicture(rand(0, $this->entrys));
            $project->setCategories($this->jsonGenerator->getJson(7, $this->entrys));
            $project->setTags($this->jsonGenerator->getJson(7, $this->entrys));
            $project->setComponents($this->jsonGenerator->getJson(7, $this->entrys));

            $this->manager->persist($project);
        }
    }
}
