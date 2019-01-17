<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", methods={"GET"}, name="category")
     */
    public function index(Category $category)
    {
        $componentsAll = $this->getDoctrine()
            ->getRepository(Component::class)->findAll();

        foreach ($componentsAll as $component) {
            if ($component->getCategories()->contains($category)) {
                $this->components[] = $component;
            }
        }

        return $this->render('05-pages/category.html.twig', [
            'category' => $category,
            'components' => $this->components,
        ]);
    }
}
