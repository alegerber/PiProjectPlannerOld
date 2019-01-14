<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Entity\Component;

class TagController extends AbstractController
{
    /**
     * @var Component[]
     */
    private $components;

    /**
     * @var Tag
     */
    private $tags;

    /**
     * @Route("/tag/{slug}", name="tag")
     */
    public function index($slug)
    {
        $this->tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findOneBy([
                'component_link' => $slug,
            ]);

        $componentsAll = $this->getDoctrine()
            ->getRepository(Component::class)->findAll();

        foreach ($componentsAll as $component) {
            if ($component->getTags()->contains($this->tags)) {
                $this->components[] = $component;
            }
        }

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $this->tags,
            'components' => $this->components,
        ]);
    }
}
