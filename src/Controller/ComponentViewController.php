<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Services\JsonArrayToArrayClasses;

class ComponentViewController extends AbstractController
{
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
     * @Route("/component/{slug}", name="component_view")
     */
    public function index($slug)
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
