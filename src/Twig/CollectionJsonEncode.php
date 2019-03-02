<?php

namespace App\Twig;

use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CollectionJsonEncode extends AbstractExtension
{
    /**
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('collection_json_encode', [$this, 'collectionJsonEncode']),
        ];
    }

    /**
     * @param PersistentCollection $collection
     * @return string
     */
    public function collectionJsonEncode(PersistentCollection $collection): string
    {
        return \json_encode($collection->toArray());
    }
}