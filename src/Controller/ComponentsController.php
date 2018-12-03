<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\TagRepository;
use App\Entity\Tag;

class ComponentsController extends AbstractController
{
    /**
     * @var $containers[][][]
     */
    private  $containers;

    /**
     * @var Category[]
     */
    private  $categories;

    /**
     * @var Tag[]
     */
    private  $tags;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    
    public function __construct(
        \Twig_Environment $twig, CategoryRepository $categoryRepository, TagRepository $tagRepository
    ) {
        $this->twig = $twig;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->findAll();
        $this->tagRepository = $tagRepository;
        $this->tags = $this->tagRepository->findAll();
    }
        
    /**
     * @Route("/component", name="component")
     */
    public function index()
    {
        $containers[0]['content'] = $this->categories;
        $containers[0]['title'] = 'Categories';
        $containers[0]['prefix'] = '/category';

        $containers[1]['content'] = $this->tags; 
        $containers[1]['title'] = 'Tags';
        $containers[1]['prefix'] = '/tag';


        return $this->render('05-pages/components.html.twig',
        array('containers' => $containers)
        );
    }
}