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
        $this->checkEmpty(Component::class);
        $this->checkEmpty(Project::class);

        $entityService = new EntityService();

        $object = $entityService->getComponentWithUniqueTagsAndCategories();
        $this->checkNotEmpty(Component::class, [$object]);

        $object = $entityService->getProjectWithUniqueTagsComponentsAndCategories();
        $this->checkNotEmpty(Project::class, [$object]);
    }

    private function checkEmpty($class): void
    {
        $standardService = new StandardService();
        $objects = $standardService->getEntityManger()->getRepository($class)->findAll();
        [$removableTags, $removableCategories] = $this->setArrayCollection($class, $objects);

        $this->assertEmpty($removableTags);
        $this->assertEmpty($removableCategories);
    }

    private function checkNotEmpty($class, array $objects): void
    {
        [$removableTags, $removableCategories] = $this->setArrayCollection($class, $objects);

        $this->assertNotEmpty($removableTags);
        $this->assertNotEmpty($removableCategories);
    }

    private function setArrayCollection($class, array $objects): array
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
        return [$removableTags, $removableCategories];
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