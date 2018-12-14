<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComponentRepository;
use App\Entity\Component;
use App\Repository\CategoryRepository;
use App\Entity\Category;

class CategoryController extends AbstractController
{
    /**
     * @var Component[]
     */
    private  $components;

    /**
     * @var Category
     */
    private  $category;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var ComponentRepository
     */
    private $componentRepository;

    /**
     * @var CategoryRepository
     */
    private  $categoryRepository;
    
    public function __construct(
        \Twig_Environment $twig, CategoryRepository $categoryRepository, ComponentRepository $componentRepository
    ) {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
        $this->componentRepository = $componentRepository;
    }
        
    /**
     * @Route("/category/{slug}", name="category")
     */
    public function index($slug)
    {
        $this->category = $this->categoryRepository->findOneBy([
            'component_link' => $slug 
        ]);

        $components = json_decode($this->category->getComponents());
        foreach($components as $key => $component){
            $this->components[$key] = $this->componentRepository->find($component);
        }

        return $this->render('05-pages/category.html.twig',
            array('category' => $this->category, 'components' => $this->components)
        );
    }
}