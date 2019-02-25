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
     * @var ObjectManager $manager
     */
    private $manager;

    /**
     * @var int $entrys
     */
    private $entrys;

    /**
     * @param ObjectManager $manager
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
            $name = 'component ' . \random_int(0, $this->entrys);
            $component->setName($name);
            $component->setSlug(
                Slugger::slugify($name)
            );
            $component->setDescription('Some Random Text ' . \random_int(0, $this->entrys));

            $tagAll = $this->manager->getRepository(Tag::class)->findAll();

            $length = \count($tagAll) - 1;

            $component->addTag(
                $tagAll[\random_int(0, $length)],
                $tagAll[\random_int(0, $length)],
                $tagAll[\random_int(0, $length)],
                $tagAll[\random_int(0, $length)]
            );

            $categoryAll = $this->manager->getRepository(Category::class)->findAll();

            $length = \count($categoryAll) - 1;

            $component->addCategory(
                $categoryAll[\random_int(0, $length)],
                $categoryAll[\random_int(0, $length)],
                $categoryAll[\random_int(0, $length)],
                $categoryAll[\random_int(0, $length)]
            );

            $imageAll = $this->manager->getRepository(Image::class)->findAll();

            $component->setImage(
                $imageAll[\random_int(0, $length)]
            );

            $this->manager->persist($component);
        }
    }

    public function getOrder(): int
    {
        return 3;
    }
}
