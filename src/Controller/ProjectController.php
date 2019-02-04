<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;
use App\Entity\Image;
use App\Form\ProjectType;
use App\Services\FormHandling;
use App\Services\RemoveDatabaseObject;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProjectController extends AbstractController
{
    /**
     * @var FormHandling
     */
    private $formHandling;

    /**
     * @var RemoveDatabaseObject
     */
    private $removeDatabaseObject;

    public function __construct(
        FormHandling $formHandling,
        RemoveDatabaseObject $removeDatabaseObject
    ) {
        $this->formHandling = $formHandling;
        $this->removeDatabaseObject = $removeDatabaseObject;
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
     * @Route("/project/new", methods={"GET", "POST"}, name="project_new")
     */
    public function new(Request $request)
    {
        $project = new Project();
        $image = new Image();
        $image->setUploadedFile(new UploadedFile('img/placeholder.jpg', 'placeholder.jpg'));

        $project->setImage($image);

        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleNew($form, $oldFileName, $request, 'project');

        if (!$redirect) {
            return $this->render('05-pages/project-new.html.twig', [
                'form' => $form->createView(),
                'tags' => $project->getTags()->toArray(),
                'categories' => $project->getCategories()->toArray(),
                'components' => $project->getComponents()->toArray(),
                'image_tags' => $project->getImage()->getTags()->toArray(),
            ]);
        } else {
            return $redirect;
        }
    }

    /**
     * @Route("/project/{slug}", methods={"GET", "POST"}, name="project_edit")
     */
    public function edit(Request $request, Project $project)
    {
        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleNew($form, $oldFileName, $request, 'project');

        if (!$redirect) {
            return $this->render('05-pages/project-view.html.twig', [
                'project' => $project,
                'form' => $form->createView(),
                'tags' => $project->getTags()->toArray(),
                'categories' => $project->getCategories()->toArray(),
                'components' => $project->getComponents()->toArray(),
                'image_tags' => $project->getImage()->getTags()->toArray(),
            ]);
        } else {
            return $redirect;
        }
    }

    /**
     * @Route("/project/{slug}/delete", methods={"GET", "POST"}, name="project_delete")
     */
    public function delete(Request $request, Project $project)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('project');
        }

        $primaryCheck = function ($item) {
            return $item->getProjects();
        };
        $secondaryCheck = function ($item) {
            return $item->getComponents();
        };

        $this->removeDatabaseObject->handleRemove($project, $primaryCheck, $secondaryCheck);

        return $this->redirectToRoute('project');
    }
}
