<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Tag;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @var FormHandling $formHandling
     */
    private $formHandling;

    /**
     * @var RemoveDatabaseObject $removeDatabaseObject
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
     * @return Response
     */
    public function index(): Response
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
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $image = new Image();
        $image->setUploadedFile(new UploadedFile('img/placeholder.jpg', 'placeholder.jpg'));

        $project->setImage($image);

        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleNew($form, $oldFileName, $request, 'project');

        if ($redirect === null) {
            return $this->render('05-pages/project-new.html.twig', [
                'project' => $project,
                'form' => $form->createView(),
            ]);
        }
        return $redirect;
    }

    /**
     * @Route("/project/{slug}", methods={"GET", "POST"}, name="project_edit")
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);

        $oldFileName = $project->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleUpdate($form, $oldFileName, $request, 'project');

        if ($redirect === null) {
            return $this->render('05-pages/project-view.html.twig', [
                'project' => $project,
                'form' => $form->createView(),
            ]);
        }
        return $redirect;
    }

    /**
     * @Route("/project/{slug}/delete", methods={"GET", "POST"}, name="project_delete")
     * @param Request $request
     * @param Project $project
     * @return RedirectResponse
     */
    public function delete(Request $request, Project $project): RedirectResponse
    {
        // @TODO Include for a user system
        // if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
        //     return $this->redirectToRoute('project');
        // }

        /**
         * @param Tag|Category $item
         * @return Collection
         */
        $primaryCheck = function ($item) {
            return $item->getProjects();
        };

        /**
         * @param Tag|Category $item
         * @return Collection
         */
        $secondaryCheck = function ($item) {
            return $item->getComponents();
        };

        $this->removeDatabaseObject->handleRemove($project, $primaryCheck, $secondaryCheck);

        return $this->redirectToRoute('project');
    }
}
