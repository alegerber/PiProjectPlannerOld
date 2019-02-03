<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class FormHandling
{
    /**
     * @var EntityManager 
     */
    private $entityManger;

    /**
     * @var Router 
     */
    private $router;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->entityManger = $entityManager;
        $this->router = $router;
    }

    

    public function FormFlushNew(Form $form, string $oldFileName): void
    {   
        $this->setFormData($form, $oldFileName);

        $this->entityManger->persist($form->getData()->getImage());
        $this->entityManger->persist($form->getData());
        $this->entityManger->flush();
    }

    public function FormFlushUpdate(Form $form, string $oldFileName): void
    {
        $this->setFormData($form, $oldFileName);

        $this->entityManger->flush();
    }

    private function setFormData(Form $form, string $oldFileName): void
    {
        if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
        $oldFileName
        ) {
            $this->uploadedFileFormHandling->handle(
                $form->getData()->getImage(),
                $this->getParameter('image_file_directory')
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
