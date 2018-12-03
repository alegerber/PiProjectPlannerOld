<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectsController extends AbstractController
{
    /**
     * @var $projects[][]
     */
    private  $projects;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Project
     */
    private $projectRepository;

    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->projects = (array) $this->projectRepository->findAll();
    }

    public function index()
    {
    
        $html = $this->twig->render('05-pages/projects.html.twig',
        array('projects' => $this->projects)
        );
        return new Response($html);
    }
}