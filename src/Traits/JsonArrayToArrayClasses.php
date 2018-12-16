<?php

namespace App\Traits;

trait JsonArrayToArrayClasses
{
    /*
    * @return array|int
    */
    public function getArrayClasses($jsonArray, $repository)
    {
        $arrayClasses = null;

        $array = json_decode($jsonArray);

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
