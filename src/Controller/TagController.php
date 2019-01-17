<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Entity\Component;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{slug}", name="tag")
     */
    public function index(Tag $tag)
    {
        /**
        * @var Component[]
        */
        $components;

        $componentsAll = $this->getDoctrine()
            ->getRepository(Component::class)->findAll();

        foreach ($componentsAll as $component) {
            if ($component->getTags()->contains($tag)) {
                $components[] = $component;
            }
        }

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $tag,
            'components' => $components,
        ]);
    }
}
