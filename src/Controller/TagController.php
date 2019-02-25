<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Tag;

class TagController extends AbstractController
{
    /**
     * @Route("/tag/{slug}", methods={"GET"}, name="tag")
     * @param Tag $tag
     * @return Response
     */
    public function index(Tag $tag): Response
    {
        $components = $tag->getComponents();

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $tag,
            'components' => $components,
        ]);
    }
}
