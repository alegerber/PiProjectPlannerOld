<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Services\GenerateArrayCollection;

class ComponentFixtures extends Fixture
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

        $this->component();

        $this->manager->flush();
    }

    private function component(): void
    {
        $generateArrayCollection = new GenerateArrayCollection();

        for ($i = 0; $i <= $this->entrys; ++$i) {
            $component = new Component();

            $componentNumber = \rand(0, $this->entrys);
            $component->setLink('component'.$componentNumber);
            $component->setTitle('component '.$componentNumber);
            $component->setName('component '.$componentNumber);
            $component->setDescription('Some Random Text '.\rand(0, $this->entrys));

            $this->manager->persist($component);
        }
    }
}
