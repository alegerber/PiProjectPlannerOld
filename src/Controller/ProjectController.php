<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Services\UploadedFileFormHandling;

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
     * @var UploadedFileFormHandling
     */
    private $uploadedFileFormHandling;

    public function __construct(UploadedFileFormHandling $uploadedFileFormHandling)
    {
        $this->uploadedFileFormHandling = $uploadedFileFormHandling;
    }

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
     * @Route("/project/{slug}", methods={"GET", "POST"}, name="project_view")
     */
    public function view(Request $request, string $slug)
    {
        $this->project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findOneBy([
                'link' => $slug,
            ]);

        $form = $this->createForm(ProjectType::class, $this->project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->uploadedFileFormHandling->handle(
                $this->project->getImage(),
                $this->getParameter('image_file_directory')
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($this->project);
            $em->persist($this->project->getImage());
            $em->flush();

            return $this->redirectToRoute('project_view', [
                'slug' => $this->project->getLink(),
            ]);
        }

        return $this->render('05-pages/project-view.html.twig', [
            'project' => $this->project,
            'form' => $form->createView(),
        ]);
    }
}
