<?php

namespace App\Twig;

use Doctrine\ORM\PersistentCollection;
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
            new TwigFilter('collection_json_encode', [$this, 'arrayCollectionJsonEncode']),
        ];
    }

    /**
     * @param PersistentCollection $arrayCollection
     * @return string
     */
    public function arrayCollectionJsonEncode(PersistentCollection $arrayCollection): string
    {
        return \json_encode($arrayCollection->toArray());
    }
}