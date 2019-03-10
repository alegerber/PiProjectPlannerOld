<?php

namespace App\Services;

use App\Utils\Slugger;
use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FormHandling
{
    /**
     * @var ParameterBagInterface $parameterBag
     */
    private $parameterBag;

    /**
     * @var EntityManagerInterface $entityManger
     */
    private $entityManger;

    /**
     * @var RouterInterface $router
     */
    private $router;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        ParameterBagInterface $parameterBag
    ) {
        $this->entityManger = $entityManager;
        $this->router = $router;
        $this->parameterBag = $parameterBag;
    }

    /**
     * @param FormInterface $form
     * @param string $oldFileName
     * @param Request $request
     * @param string $dataName
     * @return RedirectResponse|null
     */
    public function handleNew(
        FormInterface $form,
        string $oldFileName,
        Request $request,
        string $dataName
    ): ?RedirectResponse {
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->formFlushNew($form, $oldFileName);

                $request->getSession()->getFlashBag()->set(
                    'success',
                    $dataName . ' successfully created'
                );
            } catch (ORMInvalidArgumentException $e) {
                $request->getSession()->getFlashBag()->set(
                    'danger',
                    'cant\'t save ' . $dataName . ' in Database. Error:' . $e->getMessage()
                );
            }

            return new RedirectResponse(
                $this->router->generate($dataName . '_edit', [
                    'slug' => $form->getData()->getSlug(),
                ]), 301
            );
        }
        return null;
    }

    /**
     * @param FormInterface $form
     * @param string $oldFileName
     * @param Request $request
     * @param $dataName
     * @return RedirectResponse|null
     */
    public function handleUpdate(
        FormInterface $form,
        string $oldFileName,
        Request $request,
        $dataName
    ): ?RedirectResponse {
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->formFlushUpdate($form, $oldFileName);

                $request->getSession()->getFlashBag()->set(
                    'success',
                    $dataName . ' successfully updated'
                );
            } catch (ORMInvalidArgumentException $e) {
                $request->getSession()->getFlashBag()->set(
                    'danger',
                    'cant\'t update ' . $dataName . ' in Database. Error:' . $e->getMessage()
                );
            }

            return new RedirectResponse(
                $this->router->generate($dataName . '_edit', [
                    'slug' => $form->getData()->getSlug(),
                ]),301
            );
        }
        return null;
    }

    /**
     * @param FormInterface $form
     * @param string $oldFileName
     */
    private function formFlushNew(FormInterface $form, string $oldFileName): void
    {
        $this->setFormData($form, $oldFileName);

        $this->entityManger->persist($form->getData()->getImage());
        $this->entityManger->persist($form->getData());
        $this->entityManger->flush();
    }

    /**
     * @param FormInterface $form
     * @param string $oldFileName
     */
    private function formFlushUpdate(FormInterface $form, string $oldFileName): void
    {
        $this->setFormData($form, $oldFileName);

        $this->entityManger->flush();
    }

    /**
     * @param FormInterface $form
     * @param string $oldFileName
     */
    private function setFormData(FormInterface $form, string $oldFileName): void
    {
        if ($form->getData()->getImage()->getUploadedFile()->getFilename() !==
            $oldFileName
        ) {
            $this->uploadedFileHandle(
                $form->getData()->getImage(),
                $this->parameterBag->get('image_file_directory')
            );
        }

        $form->getData()->setSlug(
            Slugger::slugify($form->getData()->getName())
        );
    }

    /**
     * @param Image $object
     * @param string $parameter
     */
    public function uploadedFileHandle(Image $object, string $parameter): void
    {
        /** @var UploadedFile $file */
        $file = $object->getUploadedFile();

        $path = 'uploads/images/';

        /** TestCase */
        if($this->parameterBag->get('app_test_env')) {
            $file = new UploadedFile((string) $file, $file->getClientOriginalName(), null, null, true);
            $path ='/var/www/html/public/uploads/images/';
        }

        do {
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
        } while (\file_exists( $path . $fileName));

        try {
            $file->move(
                $parameter,
                $fileName
            );
        } catch (FileException $e) {
            echo 'Can\'t Save File, because ' . $e->getMessage() . "\n";
        }

        $object->setUploadedFile(
            new UploadedFile($path . $fileName, $file->getClientOriginalName())
        );
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(): string
    {
        return \md5(\uniqid('', true));
    }
}
