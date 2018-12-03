<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ProjectRepository;

class ProjectViewController extends AbstractController
{
    /**
     * @Route("/project/{slug}", name="project_view")
     */
    public function index($slug)
    {
        $projectepository = new ProjectRepository();

        return $this->render('05-pages/project-view.html.twig');
    }
}