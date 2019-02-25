<?php

namespace App\DataFixtures;

use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Tag;

class TagFixtures extends Fixture implements OrderedFixtureInterface
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

        $this->tag();

        $this->manager->flush();
    }

    private function tag(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $tag = new Tag();
            $name = 'tag ' . \random_int(0, $this->entrys);
            $tag->setName($name);
            $tag->setSlug(
                Slugger::slugify($name)
            );
            $this->manager->persist($tag);
        }
    }

    public function getOrder(): int
    {
        return 1;
    }
}
