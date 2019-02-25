<?php

namespace App\Tests\Services;

use App\Entity\Tag;
use App\Kernel;
use App\Entity\Image;
use App\Services\FormHandling;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FormHandlingTest extends TestCase
{
    /**
     *
     */
    public function testHandle(): void
    {
        $kernel = new Kernel(
            $_SERVER['APP_ENV'] ?? 'dev',
            $_SERVER['APP_DEBUG'] ?? ('prod' !== ($_SERVER['APP_ENV'] ?? 'dev'))
        );
        $kernel->boot();
        $container = $kernel->getContainer();

        $formHandling = $container->get(FormHandling::class);
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        $entrys = 100;

        $image = new Image();

        \copy('/var/www/html/public/img/placeholder.jpg', '/var/www/html/public/img/placeholder_test.jpg');

        $image->setUploadedFile(
            new UploadedFile('/var/www/html/public/img/placeholder_test.jpg', 'placeholder.jpg',  null, null,  true)
        );


        $image->setName('image ' . \random_int(0, $entrys));
        $image->setDescription('Some Random Text ' . \random_int(0, $entrys));

        $tagAll = $entityManager->getRepository(Tag::class)->findAll();

        $length = \count($tagAll) - 1;

        $image->addTag(
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)]
        );

        $oldScanDir = \scandir('/var/www/html/public/uploads/images', SCANDIR_SORT_NONE);

        $formHandling->uploadedFileHandle($image, $container->getParameter('image_file_directory'));

        $newScanDir = \scandir('/var/www/html/public/uploads/images', SCANDIR_SORT_NONE);

        \unlink('/var/www/html/public/uploads/images/' . \implode(\array_diff($newScanDir, $oldScanDir)));

        $this->assertTrue(\count($oldScanDir) + 1 === \count($newScanDir));
    }
}
