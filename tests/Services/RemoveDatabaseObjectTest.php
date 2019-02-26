<?php

namespace App\Tests\Services;

use App\Entity\Category;
use App\Entity\Component;
use App\Entity\Project;
use App\Entity\Tag;
use App\Tests\TestService\StandardService;
use App\Tests\TestService\EntityService;
use App\Services\RemoveDatabaseObject;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;

class RemoveDatabaseObjectTest extends TestCase
{
    public function testSetArrayCollection(): void
    {
        $standardService = new StandardService();

        $objects = $standardService->getEntityManger()->getRepository(Component::class)->findAll();
        $this->setArrayCollection(Component::class, $objects);

        $objects = $standardService->getEntityManger()->getRepository(Project::class)->findAll();
        $this->setArrayCollection(Project::class, $objects);

        $entityService = new EntityService();
        $object = $entityService->getComponentWithUniqueTagsAndCategories();
        $this->setArrayCollection(Project::class, [$object]);
    }

    private function setArrayCollection($class, $objects): void
    {
        $standardService = new StandardService();

        $object = $objects[\array_rand($objects)];

        [$primaryCheck, $secondaryCheck] = $this->setCheckFunctions($class);

        $removableTags = [];
        $standardService->getReflectionMethodResultWithArgs(RemoveDatabaseObject::class, 'setArrayCollection',
            [$object, $primaryCheck, $secondaryCheck, &$removableTags]);
        $removableCategories = [];
        $standardService->getReflectionMethodResultWithArgs(RemoveDatabaseObject::class, 'setArrayCollection',
            [$object, $primaryCheck, $secondaryCheck, &$removableCategories]);
        $this->assertEmpty($removableTags);
        $this->assertEmpty($removableCategories);
    }

    private function setCheckFunctions($class): array
    {
        if(Component::class === $class) {
            /**
             * @param Tag|Category $item
             * @return Collection
             */
            $primaryCheck = function ($item) {
                return $item->getComponents();
            };

            /**
             * @param Tag|Category $item
             * @return Collection
             */
            $secondaryCheck = function ($item) {
                return $item->getProjects();
            };
        } else {
            /**
             * @param Tag|Category $item
             * @return Collection
             */
            $primaryCheck = function ($item) {
                return $item->getProjects();
            };

            /**
             * @param Tag|Category $item
             * @return Collection
             */
            $secondaryCheck = function ($item) {
                return $item->getComponents();
            };
        }

        return [$primaryCheck, $secondaryCheck];
    }
}