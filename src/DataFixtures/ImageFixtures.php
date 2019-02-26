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

            $image->setName('image ' . \random_int(0, $this->entrys));
            $image->setDescription('Some Random Text ' . \random_int(0, $this->entrys));

            $tags = $this->manager->getRepository(Tag::class)->findAll();

            $image->addTag(\array_rand($tags, 2));

            $this->manager->persist($image);
        }
    }

    public function getOrder(): int
    {
        return 2;
    }
}
