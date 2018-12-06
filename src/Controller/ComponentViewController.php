<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComponentRepository;
use App\Entity\Component;

class ComponentViewController extends AbstractController
{
    /**
     * @var Component
     */
    private $component;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var ComponentRepository
     */
    private $componentRepository;


    public function __construct(
        \Twig_Environment $twig, ComponentRepository $componentRepository
    ) {
        $this->twig = $twig;
        $this->componentRepository = $componentRepository;
    }

    /**
     * @Route("/component/{slug}", name="component_view")
     */
    public function index($slug)
    {
        $this->component = $this->componentRepository->findOneBy([
            'link' => $slug 
        ]);

        $html = $this->twig->render('05-pages/component-view.html.twig',
            array('component' => $this->component)
        );
        
        return new Response($html);
    }
}