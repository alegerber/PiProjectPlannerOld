<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComponentRepository;
use App\Entity\Component;
use App\Repository\TagRepository;
use App\Entity\Tag;

class TagController extends AbstractController
{
    /**
     * @var Component[]
     */
    private  $components;

    /**
     * @var Tag
     */
    private  $tags;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var ComponentRepository
     */
    private $componentRepository;

    /**
     * @var TagRepository
     */
    private  $tagRepository;
    
    public function __construct(
        \Twig_Environment $twig, TagRepository $tagRepository, ComponentRepository $componentRepository
    ) {
        $this->twig = $twig;
        $this->tagRepository = $tagRepository;
        $this->componentRepository = $componentRepository;
    }
        
    /**
     * @Route("/tag/{slug}", name="tag")
     */
    public function index($slug)
    {
        $this->tag = $this->tagRepository->findOneBy([
            'component_link' => $slug 
        ]);

        $tags = json_decode($this->tag->getComponent());
        foreach($tags as $key => $tag){
            $this->components[$key] = $this->componentRepository->find($tag);
        }

        return $this->render('05-pages/tag.html.twig',
            array('tag' => $this->tag, 'components' => $this->components)
        );
    }
}