<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Entity\Project;
use App\Entity\Category;
use App\Entity\Tag;

class ProjectViewController extends AbstractController
{
    /**
     * @var Project
     */
    private $project;

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
    }

    /**
     * @Route("/project/{slug}", name="project_view")
     */
    public function index($slug)
    {
        $this->project = $this->projectRepository->findOneBy([
            'link' => $slug 
        ]);


        $html = $this->twig->render('05-pages/project-view.html.twig',
            array('project' => $this->project)
        );
        
        return new Response($html);
    }
}