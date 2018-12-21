<?php

namespace App\Services;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class JsonArrayToArrayClasses
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct()
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /*
    * Convert a json which contain id of objects to an array with these objects.
    * The object are saved in the database.
    *
    * @param string $jsonArray
    * @param mixed $repository
    *
    * @return array|int
    */
    public function getArrayClasses(string $jsonArray, $repository)
    {
        $arrayClasses = null;

        $array = $this->serializer->decode($jsonArray, 'json');

        if (is_array($array)) {
            foreach ($array as $key => $id) {
                $arrayClasses[$key] = $repository->find($id);
            }
        } else {
            $arrayClasses = $repository->find($array);
        }

        return $arrayClasses;
    }
}
