<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="dashboard")
     * @param \Twig_Environment $twig
     * @return Response
     * @throws \Twig_Error
     */
    public function index(\Twig_Environment $twig): Response
    {
        return new Response(
            $twig->render('05-pages/dashboard.html.twig')
        );
    }
}
