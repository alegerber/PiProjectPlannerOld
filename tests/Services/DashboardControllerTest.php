<?php


namespace App\Tests\Services;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Controller\DashboardController;

class DashboardControllerTest extends TestCase
{
    public function testIndex(): void
    {
        /** @var MockObject $twig */
        $twig = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with('05-pages/dashboard.html.twig');

        /** @var DashboardController $dashboardController */
        $dashboardController = new DashboardController();

        $dashboardController->index($twig);
    }
}