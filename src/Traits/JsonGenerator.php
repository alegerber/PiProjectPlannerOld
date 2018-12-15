<?php

namespace App\Traits;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

trait JsonGenerator {
    
    function getJson($number, $entrys)
    {
        $array[] = null;
        for ($i = 0; $i <= $number; $i++){
            $array[$i] = rand(0, $entrys);
        }

        $arrayClasses = null;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->encode($array, 'json');

    }

}