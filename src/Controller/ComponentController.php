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
use App\Utils\Slugger;

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

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->formHandling->handleNew($form, $oldFileName);

                $this->addFlash(
                    'success',
                    'Component successfully created'
                );    
            } catch (ORMException $e){
                $this->addFlash(
                    'success',
                    'cant\'t save Component in Database. Error:' . $e->getMessage()
                ); 
            }

            return $this->redirectToRoute('component_edit', [
                'slug' => $form->getData()->getSlug(),
            ]);
        }

        return $this->render('05-pages/component-new.html.twig', [
            'form' => $form->createView(),
            'tags' => $component->getTags()->toArray(),
            'categories' => $component->getCategories()->toArray(),
            'image_tags' => $component->getImage()->getTags()->toArray(),
        ]);
    }

    /**
     * @Route("/component/{slug}", methods={"GET", "POST"}, name="component_edit")
     */
    public function edit(Request $request, Component $component)
    {
        $form = $this->createForm(ComponentType::class, $component);

        $oldFileName = $component->getImage()->getUploadedFile()->getFilename();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->formHandling->handleUpdate($form, $oldFileName);

                $this->addFlash(
                    'success',
                    'Component successfully updated'
                );    
            } catch (ORMException $e){
                $this->addFlash(
                    'success',
                    'cant\'t update Component in Database. Error:' . $e->getMessage()
                ); 
            }


            return $this->redirectToRoute('component_edit', [
            'slug' => $component->getSlug(),
            ]);
        }

        return $this->render('05-pages/component-view.html.twig', [
            'component' => $component,
            'form' => $form->createView(),
            'tags' => $component->getTags()->toArray(),
            'categories' => $component->getCategories()->toArray(),
            'image_tags' => $component->getImage()->getTags()->toArray(),
        ]);
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
