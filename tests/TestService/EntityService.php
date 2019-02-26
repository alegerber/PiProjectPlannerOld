<?php

namespace App\Tests\TestService;

use App\Entity\Category;
use App\Entity\Project;
use App\Entity\Component;
use App\Entity\Image;
use App\Entity\Tag;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManager;
use App\DataFixtures\EntityFixtures;

class EntityService
{
    /**
     * @var EntityFixtures $entityFixtures
     */
    private $entityFixtures;

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var EntityManager $entityManager
     */
    private $entries;

    public function __construct()
    {
        $this->entityFixtures = new EntityFixtures();
        $standardService = new StandardService();
        $this->entityManager = $standardService->getEntityManger();
        $this->entries = 100;
    }

    public function getProject(): Project
    {
        return $this->entityFixtures->getProject($this->entityManager, $this->entries);
    }


    public function getComponent(): Component
    {
        return $this->entityFixtures->getComponent($this->entityManager, $this->entries);
    }

    public function getImage(): Image
    {
        return $this->entityFixtures->getImage($this->entityManager, $this->entries);
    }

    public function getCategory(): Category
    {
        return $this->entityFixtures->getCategory($this->entries);
    }

    public function getTag(): Tag
    {
        return $this->entityFixtures->getTag($this->entries);
    }

    public function getComponentWithUniqueTagsAndCategories(): Component
    {
        $component = new Component();
        $name = 'component ' . \random_int(0, $this->entries);
        $component->setName($name);
        $component->setSlug(
            Slugger::slugify($name)
        );
        $component->setDescription('Some Random Text ' . \random_int(0, $this->entries));

        $component->addTag(
            $this->getTag(),
            $this->getTag(),
            $this->getTag(),
            $this->getTag()
        );

        $component->addCategory(
            $this->getCategory(),
            $this->getCategory(),
            $this->getCategory(),
            $this->getCategory()
        );

        $component->setImage(
            $this->getImage()
        );

        return $component;
    }
    public function getProjectWithUniqueTagsComponentsAndCategories(): Project
    {
        $project = new Project();
        $name = 'project ' . \random_int(0, $this->entries);
        $project->setName($name);
        $project->setSlug(
            Slugger::slugify($name)
        );
        $project->setDescription('Some Random Text ' . \random_int(0, $this->entries));

        $project->addTag(
            $this->getTag(),
            $this->getTag(),
            $this->getTag(),
            $this->getTag()
        );

        $project->addCategory(
            $this->getCategory(),
            $this->getCategory(),
            $this->getCategory(),
            $this->getCategory()
        );

        $project->addComponent(
            $this->getComponent(),
            $this->getComponent(),
            $this->getComponent(),
            $this->getComponent()
        );

        $project->setImage(
            $this->getImage()
        );

        return $project;
    }
}