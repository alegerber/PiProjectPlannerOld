<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectViewController extends AbstractController
{
    public function index()
    {

        return $this->render('05-pages/project-view.html.twig');
    }
}