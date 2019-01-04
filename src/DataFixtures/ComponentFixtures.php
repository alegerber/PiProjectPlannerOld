<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Services\GenerateArrayCollection;

class ComponentFixtures extends Fixture implements FixtureGroupInterface
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

    public static function getGroups(): array
    {
        return ['run'];
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
            //$component->setImage(\rand(0, $this->entrys));

            // for ($k = 0; $k < 7; ++$k) {
            //     $category = new Category();
            //     $category->setName('category '.\rand(0, $this->entrys));
            //     $category->setComponentLink('category'.\rand(0, $this->entrys));

            //     $component->addCategory($category);
            // }

            // for ($k = 0; $k < 7; ++$k) {
            //     $tag = new Tag();
            //     $tag->setName('tag '.\rand(0, $this->entrys));
            //     $tag->setComponentLink('tag'.\rand(0, $this->entrys));

            //     $component->addTag($tag);
            // }

            $this->manager->persist($component);
        }
    }
}
