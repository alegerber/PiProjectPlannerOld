<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;

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
     * @var ProjectRepository
     */
    private $projectRepository;

    
    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->projects = $this->projectRepository->findAll();
    }

    /**
     * @Route("/project", name="project")
     */
    public function index()
    {
    
        $html = $this->twig->render('05-pages/projects.html.twig',
        array('projects' => (array) $this->projects)
        );
        return new Response($html);
    }
}