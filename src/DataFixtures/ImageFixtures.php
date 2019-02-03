<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Image;
use App\Entity\Tag;

class ImageFixtures extends Fixture implements OrderedFixtureInterface
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

        $this->image();

        $this->manager->flush();
    }

    private function image(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $image = new Image();

            $image->setUploadedFile(
                new UploadedFile('/var/www/html/public/img/placeholder.jpg', 'bildschirmfoto.jpg')
            );

            $image->setName('image '.\mt_rand(0, $this->entrys));
            $image->setDescription('Some Random Text '.\mt_rand(0, $this->entrys));

            $tagAll = $this->manager->getRepository(Tag::class)->findAll();

            $length = \count($tagAll) - 1;

            $image->addTag(
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)]
            );

            $this->manager->persist($image);
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
