<?php

namespace App\Traits;

trait JsonArrayToArrayClasses
{
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
