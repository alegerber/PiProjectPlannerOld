<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Services\JsonArrayToArrayClasses;

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
     * @var JsonArrayToArrayClasses
     */
    private $jsonArrayToArrayClasses;

    /**
     * @param JsonArrayToArrayClasses
     */
    public function __construct(
        JsonArrayToArrayClasses $jsonArrayToArrayClasses
    ) {
        $this->jsonArrayToArrayClasses = $jsonArrayToArrayClasses;
    }

    /**
     * @Route("/component", name="component")
     */
    public function index()
    {
        $this->categories = $this->getDoctrine()
        ->getRepository(Category::class)->findAll();

        $containers[0]['content'] = $this->categories;
        $containers[0]['title'] = 'Categories';
        $containers[0]['prefix'] = '/category';

        $this->tags = $this->getDoctrine()
        ->getRepository(Tag::class)->findAll();

        $containers[1]['content'] = $this->tags;
        $containers[1]['title'] = 'Tags';
        $containers[1]['prefix'] = '/tag';

        return $this->render('05-pages/components.html.twig', [
            'containers' => $containers,
        ]);
    }

    /**
     * @Route("/component/{slug}", name="component_view")
     */
    public function view($slug)
    {
        $this->component = $this->getDoctrine()
        ->getRepository(Component::class)->findOneBy([
            'link' => $slug,
        ]);

        $categories = $this->jsonArrayToArrayClasses->getArrayClasses(
            $this->component->getCategories(),
            $this->getDoctrine()->getRepository(Category::class)
        );

        $tags = $this->jsonArrayToArrayClasses->getArrayClasses(
            $this->component->getTags(),
            $this->getDoctrine()->getRepository(Tag::class)
        );

        $component = [
            'id' => $this->component->getId(),
            'link' => $this->component->getLink(),
            'title' => $this->component->getTitle(),
            'description' => $this->component->getDescription(),
            'picture' => $this->component->getPicture(),
            'categories' => $categories,
            'tags' => $tags,
        ];

        return $this->render('05-pages/component-view.html.twig', [
            'component' => $component,
        ]);
    }
}
