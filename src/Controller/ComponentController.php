<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\TagRepository;
use App\Entity\Tag;

class ComponentController extends AbstractController
{
    /**
     * @var[][][]
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
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @param CategoryRepository
     * @param TagRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    ) {
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

        return $this->render('05-pages/components.html.twig', [
            'containers' => $containers,
        ]);
    }
}
