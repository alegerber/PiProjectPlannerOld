<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixtures extends Fixture implements FixtureGroupInterface
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

        $this->tag();

        $this->manager->flush();
    }

    public static function getGroups(): array
    {
        return ['first'];
    }

    private function tag(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $tag = new Tag();
            $tag->setName('tag '.rand(0, $this->entrys));
            $tag->setComponentLink('tag'.rand(0, $this->entrys));

            $this->manager->persist($tag);
        }
    }
}
