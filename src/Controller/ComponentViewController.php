<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;
use App\Interfaces\JsonDatafields;
use App\Traits\JsonArrayToArrayClasses;

class ComponentViewController extends AbstractController implements JsonDatafields
{
    use JsonArrayToArrayClasses;

    /**
     * @var Component
     */
    private $component;

    /**
     * @Route("/component/{slug}", name="component_view")
     */
    public function index($slug)
    {
        $this->component = $this->getDoctrine()
        ->getRepository(Component::class)->findOneBy([
            'link' => $slug,
        ]);

        $categories = $this->getArrayClasses(
            $this->component->getCategories(),
            $this->getDoctrine()->getRepository(Category::class)
        );

        $tags = $this->getArrayClasses(
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
