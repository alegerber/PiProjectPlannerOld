<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedFileFormHandling
{
    public function handle($object, $parameter): void
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
