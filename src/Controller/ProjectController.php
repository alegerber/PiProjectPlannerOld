<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;

class ProjectController extends AbstractController
{
    /**
     * @var Project[]
     */
    private $projects;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(
        ProjectRepository $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->projects = $this->projectRepository->findAll();
    }

    /**
     * @Route("/project", name="project")
     */
    public function index()
    {
        return $this->render('05-pages/projects.html.twig',
            ['projects' => $this->projects]
        );
    }
}
