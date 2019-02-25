<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Image;

class ImagePathFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ObjectManager $manager
     */
    private $manager;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->imagePath();

        $this->manager->flush();
    }

    private function imagePath(): void
    {
        $imageAll = $this->manager->getRepository(Image::class)->findAll();

        foreach ($imageAll as $image) {
            $image->setUploadedFileFixture('img/placeholder.jpg');
        }
    }

    public function getOrder(): int
    {
        return 99;
    }
}
