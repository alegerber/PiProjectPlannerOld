<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;

class ProjectController extends AbstractController
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var Project[]
     */
    private $projects;

    /**
     * @Route("/project", name="project")
     */
    public function index()
    {
        $this->projects = $this->getDoctrine()
        ->getRepository(Project::class)->findAll();

        return $this->render('05-pages/projects.html.twig', [
            'projects' => $this->projects,
        ]);
    }

    /**
     * @Route("/project/{slug}", name="project_view")
     */
    public function view($slug)
    {
        $this->project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findOneBy([
                'link' => $slug,
            ]);
            
        return $this->render('05-pages/project-view.html.twig', [
            'project' => $this->project,
        ]);
    }
}
