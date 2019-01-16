<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\ComponentType;
use App\Services\UploadedFileFormHandling;

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
     * @Route("/component", name="component")
     */
    public function index()
    {
        $this->categories = $this->getDoctrine()
        ->getRepository(Category::class)->findAll();

        $this->containers[0]['content'] = $this->categories;
        $this->containers[0]['title'] = 'Categories';
        $this->containers[0]['prefix'] = '/category';

        $this->tags = $this->getDoctrine()
        ->getRepository(Tag::class)->findAll();

        $this->containers[1]['content'] = $this->tags;
        $this->containers[1]['title'] = 'Tags';
        $this->containers[1]['prefix'] = '/tag';

        return $this->render('05-pages/components.html.twig', [
            'containers' => $this->containers,
        ]);
    }

    /**
     * @Route("/component/{slug}", name="component_view")
     */
    public function view(Request $request, string $slug)
    {
        $this->component = $this->getDoctrine()
        ->getRepository(Component::class)->findOneBy([
            'link' => $slug,
        ]);

        $form = $this->createForm(ComponentType::class, $this->component);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->getData()->getImage()->getUploadedFile() !=
            $this->component->getImage()->getUploadedFile()
            ) {
                $this->uploadedFileFormHandling->handle(
                    $this->component->getImage(),
                    $this->getParameter('image_file_directory')
                );
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('component_view', [
                'slug' => $this->component->getLink(),
            ]);
        }

        return $this->render('05-pages/component-view.html.twig', [
            'component' => $this->component,
            'form' => $form->createView(),
        ]);
    }
}
