<?php


namespace App\Tests\Services;

use App\Controller\ProjectController;
use App\Entity\Category;
use App\Entity\Project;
use App\Entity\Tag;
use App\Services\FormHandling;
use App\Services\RemoveDatabaseObject;
use App\Tests\TestService\StandardService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouterInterface;

class ProjectControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $standardService = new StandardService();

        /** @var MockObject $formHandling */
        $formHandling = $this->getMockBuilder(FormHandling::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var MockObject $removeDatabaseObject */
        $removeDatabaseObject = $this->getMockBuilder(RemoveDatabaseObject::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var MockObject $twig */
        $twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        /**
         * @var Project[]
         */
        $projects = $standardService->getEntityManger()
            ->getRepository(Project::class)->findAll();

        $twig->expects($this->once())
            ->method('render')
            ->with('05-pages/projects.html.twig', [
                'projects' => $projects,
            ]);

        /** @var MockObject $routerInterface */
        $routerInterface = $this->getMockBuilder(RouterInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var ProjectController $projectController */
        $projectController = new ProjectController($formHandling, $removeDatabaseObject, $twig, $routerInterface);

        $projectController->setContainer($standardService->getContainer());
        //$projectController->index();

    }

}