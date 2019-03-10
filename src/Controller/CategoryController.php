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
     * @param \Twig_Environment $twig
     * @return Response
     */
    public function index(Category $category, \Twig_Environment $twig): Response
    {
        try {
            return new Response(
                $twig->render('05-pages/category.html.twig', [
                    'category' => $category,
                    'components' => $category->getComponents(),
                ])
            );
        } catch (\Twig_Error $e) {
            return new Response($e->getMessage(), 500);
        }
    }
}
