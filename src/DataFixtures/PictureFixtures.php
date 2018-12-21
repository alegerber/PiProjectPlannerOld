<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Picture;
use App\Services\JsonGenerator;

class PictureFixtures extends Fixture
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

        $this->picture();

        $this->manager->flush();
    }

    private function picture()
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $picture = new Picture();
            $picture->setUrl('/files/pictures/pic'.rand(0, $this->entrys).'.jpg');
            $picture->setTitle('picture '.rand(0, $this->entrys));
            $picture->setDescription('Some Random Text '.rand(0, $this->entrys));
            $picture->setTags($this->jsonGenerator->getJson(7, $this->entrys));

            $this->manager->persist($picture);
        }
    }
}
