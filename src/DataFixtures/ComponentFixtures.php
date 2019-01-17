<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Component;

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
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $component = new Component();

            $componentNumber = \rand(0, $this->entrys);
            $component->setName('component '.$componentNumber);
            $component->setDescription('Some Random Text '.\rand(0, $this->entrys));

            $this->manager->persist($component);
        }
    }
}
