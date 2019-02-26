<?php

namespace App\Tests\Services;

use App\Entity\Tag;
use App\Tests\TestService\StandardService;
use App\Entity\Image;
use App\Services\FormHandling;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormHandlingTest extends TestCase
{

    public function testUploadedFileHandle(): void
    {
        $standardService = new  StandardService();
        $container = $standardService->getContainer();
        $formHandling = $container->get(FormHandling::class);

        $image = $this->setImage($container);

        $oldScanDir = \scandir('/var/www/html/public/uploads/images', SCANDIR_SORT_NONE);
        $formHandling->uploadedFileHandle($image, $container->getParameter('image_file_directory'));

        $newScanDir = \scandir('/var/www/html/public/uploads/images', SCANDIR_SORT_NONE);
        \unlink('/var/www/html/public/uploads/images/' . \implode(\array_diff($newScanDir, $oldScanDir)));

        $this->assertTrue(\count($oldScanDir) + 1 === \count($newScanDir));
    }

    public function testGenerateUniqueFileName(): void
    {
        $standardService = new  StandardService();
        $result = $standardService->getReflectionMethodResult(FormHandling::class,'generateUniqueFileName');

        $this->assertTrue(\strlen($result) ===  32 && \is_string($result));
    }


    private function setImage(ContainerInterface $container): Image
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
