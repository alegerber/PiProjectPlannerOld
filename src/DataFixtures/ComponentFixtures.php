<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Component;
use App\Services\JsonGenerator;

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

        $this->component();

        $this->manager->flush();
    }

    private function component()
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $component = new Component();
            $componentNumber = rand(0, $this->entrys);
            $component->setLink('component'.$componentNumber);
            $component->setTitle('component '.$componentNumber);
            $component->setDescription('Some Random Text '.rand(0, $this->entrys));
            $component->setPicture(rand(0, $this->entrys));
            $component->setCategories($this->jsonGenerator->getJson(7, $this->entrys));
            $component->setTags($this->jsonGenerator->getJson(7, $this->entrys));

            $this->manager->persist($component);
        }
    }
}
