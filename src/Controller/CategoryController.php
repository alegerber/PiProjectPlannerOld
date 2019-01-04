<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @var Component[]
     */
    private $components;

    /**
     * @var Category
     */
    private $category;

    /**
     * @Route("/category/{slug}", name="category")
     */
    public function index($slug)
    {
        $this->category = $this->getDoctrine()
        ->getRepository(Category::class)->findOneBy([
            'component_link' => $slug,
        ]);

        $components = $this->getDoctrine()
            ->getRepository(Component::class)->findAll();

        foreach ($components as $component) {
            if ($component->getCategories()->contains($this->category)) {
                $this->components[] = $component;
            }
        }

        return $this->render('05-pages/category.html.twig', [
            'category' => $this->category,
            'components' => $this->components,
        ]);
    }
}
