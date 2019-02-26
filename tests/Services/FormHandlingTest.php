<?php

namespace App\Tests\Services;

use App\Tests\TestService\StandardService;
use App\Tests\TestService\EntityService;
use App\Services\FormHandling;
use PHPUnit\Framework\TestCase;

class FormHandlingTest extends TestCase
{

    public function testUploadedFileHandle(): void
    {
        $standardService = new  StandardService();
        $container = $standardService->getContainer();
        $formHandling = $container->get(FormHandling::class);

        $entityService = new EntityService();
        $image = $entityService->getImage($container);

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
}
