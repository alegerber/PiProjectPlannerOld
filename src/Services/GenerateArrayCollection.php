<?php

namespace App\Services;

class GenerateArrayCollection
{

    public function getArrayCollection(int $itemSize, $repository)
    {
        $arrayCollection = new ArrayCollection();

        for ($i = 0; $i < $itemSize; ++$i) {
            $item = null;


            $arrayCollection->add($item);
        }

        return $arrayCollection;
    }
}
