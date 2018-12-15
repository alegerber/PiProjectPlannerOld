<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComponentRepository;
use App\Entity\Component;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Interfaces\JsonDatafields;
use App\Traits\JsonArrayToArrayClasses;

class ComponentViewController extends AbstractController implements JsonDatafields
{

    use JsonArrayToArrayClasses;

    /**
     * @var Component
     */
    private $component;

    /**
     * @var ComponentRepository
     */
    private $componentRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    
    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(
        ComponentRepository $componentRepository, CategoryRepository $categoryRepository,
        TagRepository $tagRepository
    ) {
        $this->componentRepository = $componentRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @Route("/component/{slug}", name="component_view")
     */
    public function index($slug)
    {
        $this->component = $this->componentRepository->findOneBy([
            'link' => $slug 
        ]);

        $categories = $this->getArrayClasses($this->component->getCategories(), $this->categoryRepository);
        $tags = $this->getArrayClasses($this->component->getTags(), $this->tagRepository);

        $component = [
            'id' => $this->component->getId(),
            'link' => $this->component->getLink(),
            'title' => $this->component->getTitle(),
            'description' => $this->component->getDescription(),
            'picture' => $this->component->getPicture(),
            'categories' => $categories,
            'tags' => $tags,
        ];

        return $this->render('05-pages/component-view.html.twig',[
            'component' => $component
        ]);
    
    }
}