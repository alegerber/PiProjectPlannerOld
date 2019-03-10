<?php declare(strict_types = 1);

namespace App\Services;

use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Component;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;

class RemoveDatabaseObject
{
    /**
     * @var EntityManagerInterface $entityManger
     */
    private $entityManger;

    public function __construct(
        EntityManagerInterface $entityManager
    ) {
        $this->entityManger = $entityManager;
    }

    /**
     * @param Project|Component $object
     * @param $primaryCheck
     * @param $secondaryCheck
     */
    public function handleRemove($object, $primaryCheck, $secondaryCheck): void
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

    /**
     * @param Project|Component $object
     * @param $primaryCheck
     * @param $secondaryCheck
     * @param Tag[]|Category[]|array $removableArrayCollection
     */
    private function setArrayCollection($object, $primaryCheck, $secondaryCheck, &$removableArrayCollection): void
    {
        foreach ($object->getTags() as $tag) {
            if (($primaryCheck($tag)->contains($object) && 1 === count($primaryCheck($tag))) &&
                $secondaryCheck($tag)->isEmpty()) {
                $removableArrayCollection[] = $tag;
            }
        }
    }

    /**
     * @param Tag[]|Category[]|array $arrayCollection
     */
    private function removeArrayCollection($arrayCollection): void
    {
        foreach ($arrayCollection as $removableItem) {
            $this->entityManger->remove($removableItem);
        }
    }
}
