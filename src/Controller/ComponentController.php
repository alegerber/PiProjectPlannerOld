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
use App\Services\UploadedFileFormHandling;
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
     * @var Component
     */
    private $component;

    /**
     * @var UploadedFileFormHandling
     */
    private $uploadedFileFormHandling;

    public function __construct(UploadedFileFormHandling $uploadedFileFormHandling)
    {
        $this->uploadedFileFormHandling = $uploadedFileFormHandling;
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
            if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
            $oldFileName
            ) {
                $this->uploadedFileFormHandling->handle(
                    $form->getData()->getImage(),
                    $this->getParameter('image_file_directory')
                );
            }

            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($image);
            $entityManger->persist($component);
            $entityManger->flush();

            return $this->redirectToRoute('component_edit', [
                'slug' => $component->getSlug(),
            ]);
        }

        return $this->render('05-pages/component-new.html.twig', [
            'form' => $form->createView(),
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
            if ($form->getData()->getImage()->getUploadedFile()->getFilename() !=
            $oldFileName
            ) {
                $this->uploadedFileFormHandling->handle(
                    $form->getData()->getImage(),
                    $this->getParameter('image_file_directory')
                );
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('component_view', [
                'slug' => $component->getSlug(),
            ]);
        }

        return $this->render('05-pages/component-view.html.twig', [
            'component' => $component,
            'form' => $form->createView(),
        ]);
    }
}
