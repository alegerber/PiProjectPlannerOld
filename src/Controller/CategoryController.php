<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Component;
use App\Entity\Category;
use App\Services\JsonArrayToArrayClasses;

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
     * @var ComponentRepository
     */
    private $componentRepository;

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
     * @Route("/category/{slug}", name="category")
     */
    public function index($slug)
    {
        $this->category = $this->getDoctrine()
        ->getRepository(Category::class)->findOneBy([
            'component_link' => $slug,
        ]);

        // $components = \json_decode($this->category->getComponents());

        // $this->componentRepository = $this->getDoctrine()
        // ->getRepository(Component::class);

        // foreach ($components as $key => $component) {
        //     $this->components[$key] = $this->componentRepository->find($component);
        // }

        $this->components = $this->jsonArrayToArrayClasses->getArrayClasses(
            $this->category->getComponents(),
            $this->getDoctrine()->getRepository(Component::class)
        );

        return $this->render('05-pages/category.html.twig', [
            'category' => $this->category,
            'components' => $this->components,
        ]);
    }
}
