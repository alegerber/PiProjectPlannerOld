<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Entity\Component;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{slug}", methods={"GET"}, name="tag")
     */
    public function index(Tag $tag)
    {
        $components = $tag->getComponents();

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $tag,
            'components' => $components,
        ]);
    }
}
