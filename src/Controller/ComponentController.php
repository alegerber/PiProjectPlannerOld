<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Entity\Image;
use App\Form\ComponentType;
use App\Services\FormHandling;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ComponentController extends AbstractController
{
    /**
     * @var mixed[][]
     */
    private $containers;

    /**
     * @var Category[]
     */
    private $categories;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @var FormHandling
     */
    private $formHandling;

    public function __construct(FormHandling $formHandling)
    {
        $this->formHandling = $formHandling;
    }

    /**
     * @Route("/component", methods={"GET"}, name="component")
     */
    public function index()
    {
        $this->categories = $this->getDoctrine()
        ->getRepository(Category::class)->findAll();

        $this->containers[0]['content'] = $this->categories;
        $this->containers[0]['name'] = 'Categories';
        $this->containers[0]['prefix'] = '/category';

        $this->tags = $this->getDoctrine()
        ->getRepository(Tag::class)->findAll();

        $this->containers[1]['content'] = $this->tags;
        $this->containers[1]['name'] = 'Tags';
        $this->containers[1]['prefix'] = '/tag';

        return $this->render('05-pages/components.html.twig', [
            'containers' => $this->containers,
        ]);
    }

    /**
     * @Route("/component/new", methods={"GET", "POST"}, name="component_new")
     */
    public function new(Request $request)
    {
        $component = new Component();

        $image = new Image();
        $image->setUploadedFile(new UploadedFile('img/placeholder.jpg', 'placeholder.jpg'));
        $component->setImage($image);

        $form = $this->createForm(ComponentType::class, $component);

        $oldFileName = $component->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleNew($form, $oldFileName, $request, 'component');

        if (!$redirect) {
            return $this->render('05-pages/component-new.html.twig', [
                'form' => $form->createView(),
                'tags' => $component->getTags()->toArray(),
                'categories' => $component->getCategories()->toArray(),
                'image_tags' => $component->getImage()->getTags()->toArray(),
            ]);
        } else {
            return $redirect;
        }
    }

    /**
     * @Route("/component/{slug}", methods={"GET", "POST"}, name="component_edit")
     */
    public function edit(Request $request, Component $component)
    {
        $form = $this->createForm(ComponentType::class, $component);

        $oldFileName = $component->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        $redirect = $this->formHandling->handleUpdate($form, $oldFileName, $request, 'component');

        if (!$redirect) {
            return $this->render('05-pages/component-view.html.twig', [
                'component' => $component,
                'form' => $form->createView(),
                'tags' => $component->getTags()->toArray(),
                'categories' => $component->getCategories()->toArray(),
                'image_tags' => $component->getImage()->getTags()->toArray(),
            ]);
        } else {
            return $redirect;
        }
    }

    /**
     * @Route("/component/{slug}/delete", methods={"GET", "POST"}, name="component_delete")
     */
    public function delete(Request $request, Component $component)
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('component');
        }

        $entityManger = $this->getDoctrine()->getManager();

        $image = $component->getImage();
        $entityManger->remove($component);
        $entityManger->remove($image);

        $entityManger->flush();

        return $this->redirectToRoute('component');
    }
}
