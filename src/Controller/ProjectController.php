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
     * @var UploadedFileFormHandling
     */
    private $uploadedFileFormHandling;

    public function __construct(UploadedFileFormHandling $uploadedFileFormHandling)
    {
        $this->uploadedFileFormHandling = $uploadedFileFormHandling;
    }

    /**
     * @Route("/project", methods={"GET"}, name="project")
     */
    public function index()
    {
        /**
        * @var Project[]
        */
        $projects = $this->getDoctrine()
        ->getRepository(Project::class)->findAll();

        return $this->render('05-pages/projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/project/{slug}", methods={"GET", "POST"}, name="project_view")
     */
    public function view(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
            $oldFileName
            ) {
                $this->uploadedFileFormHandling->handle(
                    $form->getData()->getImage(),
                    $this->getParameter('image_file_directory')
                );
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_view', [
                'slug' => $project->getSlug(),
            ]);
        }

        return $this->render('05-pages/project-view.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }
}
