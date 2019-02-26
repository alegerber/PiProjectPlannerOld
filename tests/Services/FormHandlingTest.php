<?php

namespace App\Tests\Services;

use App\Entity\Component;
use App\Form\ComponentType;
use App\Tests\TestService\StandardService;
use App\Tests\TestService\EntityService;
use App\Services\FormHandling;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FormHandlingTest extends TestCase
{
    public function testSetFormData(): void
    {
        $standardService = new  StandardService();

        /** @var string $oldFileName */
        $oldFileName = null;

        /** @var UploadedFile $originFile */
        $originFile = null;

        $form = $this->prepareFormData($oldFileName, $originFile, $standardService);
        $form->getData()->setName('sfaERq awsw sda');

        \copy('/var/www/html/public/img/placeholder.jpg', '/var/www/html/public/img/placeholder_test.jpg');
        $oldFile = new UploadedFile('/var/www/html/public/img/placeholder_test.jpg', 'placeholder_test.jpg');
        $form->getData()->getImage()->setUploadedFile(
            $oldFile
        );

        $standardService->getReflectionMethodResultWithArgs(FormHandling::class, 'setFormData',
            [$form, $oldFileName]);

        $this->assertEquals('sfaerq-awsw-sda', $form->getData()->getSlug());
        $this->assertEquals($oldFile, $form->getData()->getImage()->getUploadedFile());
        $this->assertNotEquals($oldFile->getFilename(),
            $form->getData()->getImage()->getUploadedFile()->getFilename());
        \unlink('/var/www/html/public/uploads/images/' . $form->getData()->getImage()->getUploadedFile()->getFilename());

        /*
         * second route now with change filename
         */

        /** @var string $oldFileName */
        $oldFileName = null;

        /** @var UploadedFile $originFile */
        $originFile = null;

        $form = $this->prepareFormData($oldFileName, $originFile, $standardService);
        $standardService->getReflectionMethodResultWithArgs(FormHandling::class, 'setFormData',
            [$form, $oldFileName]);

        $this->assertEquals($originFile, $form->getData()->getImage()->getUploadedFile());
        $this->assertEquals($originFile->getFilename(),
            $form->getData()->getImage()->getUploadedFile()->getFilename());

    }

    private function prepareFormData(
        &$oldFileName,
        &$originFile,
        StandardService $standardService
    ): FormInterface {
        $entityManger = $standardService->getEntityManger();
        $components = $entityManger->getRepository(Component::class)->findAll();
        $component = $components[\array_rand($components)];

        $formFactory = $standardService->getFormFactory();

        $originFile = new UploadedFile('/var/www/html/public/img/placeholder.jpg', 'placeholder.jpg');
        $component->getImage()->setUploadedFile(
            $originFile
        );

        $oldFileName = $component->getImage()->getUploadedFile()->getFilename();

        return $formFactory->create(ComponentType::class, $component);
    }

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

        $this->assertSame(\count($oldScanDir) + 1, \count($newScanDir));
    }

    public function testGenerateUniqueFileName(): void
    {
        $standardService = new  StandardService();
        $result = $standardService->getReflectionMethodResult(FormHandling::class, 'generateUniqueFileName');

        $this->assertSame(\strlen($result), 32);
        $this->assertInternalType('string', $result);
    }
}
