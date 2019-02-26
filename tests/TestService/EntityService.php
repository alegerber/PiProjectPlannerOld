<?php


namespace App\Tests\TestService;


use App\Entity\Image;
use App\Entity\Tag;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EntityService
{
    public function getImage(ContainerInterface $container): Image
    {
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        $entrys = 100;

        $image = new Image();

        \copy('/var/www/html/public/img/placeholder.jpg', '/var/www/html/public/img/placeholder_test.jpg');

        $image->setUploadedFile(
            new UploadedFile('/var/www/html/public/img/placeholder_test.jpg', 'placeholder.jpg')
        );


        $image->setName('image ' . \random_int(0, $entrys));
        $image->setDescription('Some Random Text ' . \random_int(0, $entrys));

        $tagAll = $entityManager->getRepository(Tag::class)->findAll();

        $length = \count($tagAll) - 1;

        $image->addTag(
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)]
        );
        return $image;
    }
}