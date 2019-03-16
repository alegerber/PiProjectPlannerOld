<?php declare(strict_types = 1);


namespace App\Tests\Services;

use App\Controller\ComponentController;
use App\Entity\Category;
use App\Entity\Tag;
use App\Services\FormHandling;
use App\Services\RemoveDatabaseObject;
use App\Tests\TestService\StandardService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouterInterface;

class ComponentControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $standardService = new StandardService();

        /** @var MockObject $formHandling */
        $formHandling = $this->createMock(FormHandling::class);

        /** @var MockObject $removeDatabaseObject */
        $removeDatabaseObject = $this->createMock(RemoveDatabaseObject::class);

        /** @var MockObject $twig */
        $twig = $this->createMock(\Twig_Environment::class);

        /** @var mixed[][] $containers */
        $containers = null;

        $categories = $standardService->getEntityManger()
            ->getRepository(Category::class)->findAll();

        $containers[0]['content'] = $categories;
        $containers[0]['name'] = 'Categories';
        $containers[0]['prefix'] = '/category';

        $tags = $standardService->getEntityManger()
            ->getRepository(Tag::class)->findAll();

        $containers[1]['content'] = $tags;
        $containers[1]['name'] = 'Tags';
        $containers[1]['prefix'] = '/tag';

        $twig->expects($this->once())
            ->method('render')
            ->with('05-pages/components.html.twig', [
                'containers' => $containers,
            ]);

        /** @var MockObject $routerInterface */
        $routerInterface = $this->createMock(RouterInterface::class);

        /** @var ComponentController $componentController */
        $componentController = new ComponentController($formHandling, $removeDatabaseObject, $twig, $routerInterface);

        $componentController->setContainer($standardService->getContainer());
        //$componentController->index();

    }

}