<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", methods={"GET"}, name="category")
     * @param Category $category
     * @return Response
     */
    public function index(Category $category): Response
    {
        $components = $category->getComponents();

        return $this->render('05-pages/category.html.twig', [
            'category' => $category,
            'components' => $components,
        ]);
    }
}
