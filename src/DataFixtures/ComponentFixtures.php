<?php

namespace App\DataFixtures;

use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Component;
use App\Entity\Image;
use App\Entity\Tag;
use App\Entity\Category;

class ComponentFixtures extends Fixture implements OrderedFixtureInterface
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
            $name = 'component '.\mt_rand(0, $this->entrys);
            $component->setName($name);
            $component->setSlug(
                Slugger::slugify($name)
            );
            $component->setDescription('Some Random Text '.\mt_rand(0, $this->entrys));

            $tagAll = $this->manager->getRepository(Tag::class)->findAll();

            $length = \count($tagAll) - 1;

            $component->addTag(
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)]
            );

            $categoryAll = $this->manager->getRepository(Category::class)->findAll();

            $length = \count($categoryAll) - 1;

            $component->addCategory(
                $categoryAll[\mt_rand(0, $length)],
                $categoryAll[\mt_rand(0, $length)],
                $categoryAll[\mt_rand(0, $length)],
                $categoryAll[\mt_rand(0, $length)]
            );

            $imageAll = $this->manager->getRepository(Image::class)->findAll();

            $component->setImage(
                $imageAll[\mt_rand(0, $length)]
            );

            $this->manager->persist($component);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
