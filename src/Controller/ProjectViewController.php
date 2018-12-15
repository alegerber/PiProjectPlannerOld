<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Repository\ProjectRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Repository\ComponentRepository;
use App\Entity\Project;
use App\Interfaces\JsonDatafields;
use App\Traits\JsonArrayToArrayClasses;

class ProjectViewController extends AbstractController implements JsonDatafields
{

    use JsonArrayToArrayClasses;
    
    /**
     * @var Project
     */
    private $project;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @var ComponentRepository
     */
    private $componentRepository;
    


    public function __construct(
        \Twig_Environment $twig, ProjectRepository $projectRepository, 
        CategoryRepository $categoryRepository, TagRepository $tagRepository,
        ComponentRepository $componentRepository
    ) {
        $this->twig = $twig;
        $this->projectRepository = $projectRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->componentRepository = $componentRepository;
    }

    /**
     * @Route("/project/{slug}", name="project_view")
     */
    public function index($slug)
    {
        $this->project = $this->projectRepository->findOneBy([
            'link' => $slug 
        ]);

        $categories = $this->getArrayClasses($this->project->getCategories(), $this->categoryRepository);
        $tags = $this->getArrayClasses($this->project->getTags(), $this->tagRepository);
        $components = $this->getArrayClasses($this->project->getComponents(), $this->componentRepository);
        
        $project = [
            'id' => $this->project->getId(),
            'link' => $this->project->getLink(),
            'title' => $this->project->getTitle(),
            'description' => $this->project->getDescription(),
            'picture' => $this->project->getPicture(),
            'categories' => $categories,
            'tags' => $tags,
            'components' => $components,
        ];

        $html = $this->twig->render('05-pages/project-view.html.twig',
            array('project' => $project)
        );
        
        return new Response($html);
    }
}