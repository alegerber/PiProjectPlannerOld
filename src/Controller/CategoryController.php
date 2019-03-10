<?php declare(strict_types = 1);

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
     * @throws \Twig_Error
     */
    public function index(Category $category, \Twig_Environment $twig): Response
    {
        return new Response(
            $twig->render('05-pages/category.html.twig', [
                'category' => $category,
                'components' => $category->getComponents(),
            ])
        );
    }
}
