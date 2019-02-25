<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="dashboard")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('05-pages/dashboard.html.twig');
    }
}
