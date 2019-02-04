<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

class RemoveDatabaseObject
{
    /**
     * @var EntityManager
     */
    private $entityManger;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManger = $entityManager;
    }

    public function handleRemove($object, $primaryCheck, $secondaryCheck)
    {
        $image = $object->getImage();

        $removableTags = [];
        $removableCategories = [];

        $this->setArrayCollection($object, $primaryCheck, $secondaryCheck, $removableTags);
        $this->setArrayCollection($object, $primaryCheck, $secondaryCheck, $removableCategories);

        $this->entityManger->remove($object);
        $this->entityManger->remove($image);

        $this->removeArrayCollection($removableTags);
        $this->removeArrayCollection($removableCategories);

        $this->entityManger->flush();
    }

    private function setArrayCollection($object, $primaryCheck, $secondaryCheck, &$removableArrayCollection)
    {
        foreach ($object->getTags() as $tag) {
            if (($primaryCheck($tag)->contains($object) && 1 === count($primaryCheck($tag))) &&
                $secondaryCheck($tag)->isEmpty()) {
                $removableArrayCollection[] = $tag;
            }
        }
    }

    private function removeArrayCollection($arrayCollection)
    {
        foreach ($arrayCollection as $removableItem) {
            $this->entityManger->remove($removableItem);
        }
    }
}
