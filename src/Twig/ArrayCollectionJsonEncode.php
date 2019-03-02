<?php

namespace App\Twig;

use Doctrine\Common\Collections\ArrayCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ArrayCollectionJsonEncode extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('array_collection_json_encode', [$this, 'arrayCollectionJsonEncode']),
        ];
    }

    /**
     * @param ArrayCollection $arrayCollection
     * @return string
     */
    public function arrayCollectionJsonEncode($arrayCollection): string
    {
        return \json_encode($arrayCollection->toArray());
    }
}