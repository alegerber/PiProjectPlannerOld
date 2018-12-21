<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;
use App\Services\JsonGenerator;

class TagFixtures extends Fixture
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

        $this->tag();

        $this->manager->flush();
    }

    private function tag()
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $tag = new Tag();
            $tag->setName('tag '.rand(0, $this->entrys));
            $tag->setComponentLink('tag'.rand(0, $this->entrys));
            $tag->setProjects($this->jsonGenerator->getJson(7, $this->entrys));
            $tag->setComponents($this->jsonGenerator->getJson(7, $this->entrys));

            $this->manager->persist($tag);
        }
    }
}
