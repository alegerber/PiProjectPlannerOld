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
        $this->tag = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findOneBy([
                'component_link' => $slug,
            ]);

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $this->tag,
            'components' => $this->components,
        ]);
    }
}
