<?php

namespace App\Services;

class ChoiceBuilder
{
    public function getArray($repository)
    {
        $all = $repository->findAll();

        $array = [];

        foreach ($all as $item) {
            $array[$item->getName()] = $item;
        }

        return $array;
    }
}
