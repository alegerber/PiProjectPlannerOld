<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
        ProjectRepository $projectRepository, 
        CategoryRepository $categoryRepository, TagRepository $tagRepository,
        ComponentRepository $componentRepository
    ) {
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

        return $this->render('05-pages/project-view.html.twig',[
            'project' => $project
        ]);
    }
}