<?php

namespace App\Tests\Services;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Entity\Category;
use App\Controller\CategoryController;

class CategoryControllerTest extends TestCase
{
    public function testIndex(): void
    {
        /** @var MockObject $twig */
        $twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var Category $category */
        $category = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with('05-pages/category.html.twig', [
                'category' => $category,
                'components' => $category->getComponents(),
            ]);

        /** @var CategoryController $categoryController */
        $categoryController = new CategoryController();

        $categoryController->index($category, $twig);
    }
}