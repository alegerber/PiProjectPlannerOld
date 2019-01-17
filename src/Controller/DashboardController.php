<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"}, name="dashboard")
     */
    public function index()
    {
        return $this->render('05-pages/dashboard.html.twig');
    }
}
