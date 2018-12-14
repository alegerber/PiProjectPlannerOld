<?php

namespace App\Traits;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

trait JsonArrayToArrayClasses {
    /*
    * @return array|int
    */
    public function getArrayClasses($jsonArray, $repository) {

        $arrayClasses = null;

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $array = $serializer->decode($jsonArray, 'json');

        if(is_array($array)){
            foreach($array as $key => $id){
                $arrayClasses[$key] = $repository->find($id);
            }
        } else {
            $arrayClasses = $repository->find($array);
        }
        
        return $arrayClasses;
    }
}