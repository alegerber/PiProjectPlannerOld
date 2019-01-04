<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Entity\Tag;

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

        return $this->render('05-pages/component-view.html.twig', [
            'component' => $component,
        ]);
    }
}
