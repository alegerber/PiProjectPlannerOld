<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FormHandling
{
    /**
     * @var ParameterBag
     */
    private $parameterBag;

    /**
     * @var EntityManager
     */
    private $entityManger;

    /**
     * @var Router
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

    public function handleNew(Form $form, string $oldFileName, Request $request, $dataName)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->FormFlushNew($form, $oldFileName);

                $request->getSession()->getFlashBag()->set(
                    'success',
                    $dataName.' successfully created'
                );
            } catch (ORMException $e) {
                $request->getSession()->getFlashBag()->set(
                    'danger',
                    'cant\'t save '.$dataName.' in Database. Error:'.$e->getMessage()
                );
            }

            return new RedirectResponse(
                $this->router->generate($dataName.'_edit', [
                    'slug' => $form->getData()->getSlug(),
                ])
            );
        } else {
            return false;
        }
    }

    public function handleUpdate(Form $form, string $oldFileName, Request $request, $dataName)
    {
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->formFlushUpdate($form, $oldFileName);

                $request->getSession()->getFlashBag()->set(
                    'success',
                    $dataName.' successfully updated'
                );
            } catch (ORMException $e) {
                $request->getSession()->getFlashBag()->set(
                    'danger',
                    'cant\'t update '.$dataName.' in Database. Error:'.$e->getMessage()
                );
            }

            return new RedirectResponse(
                $this->router->generate($dataName.'_edit', [
                    'slug' => $form->getData()->getSlug(),
                ])
            );
        } else {
            return false;
        }
    }

    private function formFlushNew(Form $form, string $oldFileName): void
    {
        $this->setFormData($form, $oldFileName);

        $this->entityManger->persist($form->getData()->getImage());
        $this->entityManger->persist($form->getData());
        $this->entityManger->flush();
    }

    private function formFlushUpdate(Form $form, string $oldFileName): void
    {
        $this->setFormData($form, $oldFileName);

        $this->entityManger->flush();
    }

    private function setFormData(Form $form, string $oldFileName): void
    {
        if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
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

    public function uploadedFileHandle($object, $parameter): void
    {
        /**
         * @var UploadedFile
         */
        $file = $object->getUploadedFile();

        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

        try {
            $file->move(
                $parameter,
                $fileName
            );
        } catch (\FileException $e) {
            echo 'Can\'t Save File'.$e->getMessage()."\n";
        }

        $object->setUploadedFile(
            new UploadedFile('uploads/images'.'/'.$fileName, $file->getClientOriginalName())
        );
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(): string
    {
        return \md5(\uniqid());
    }
}
