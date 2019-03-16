<?php declare(strict_types = 1);

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
        $twig = $this->createMock(\Twig_Environment::class);

        /** @var Category $category */
        $category = $this->createMock(Category::class);

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