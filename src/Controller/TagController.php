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
     * @param \Twig_Environment $twig
     * @return Response
     */
    public function index(Tag $tag, \Twig_Environment $twig): Response
    {
        try {
            return new Response(
                $twig->render('05-pages/tag.html.twig', [
                    'tag' => $tag,
                    'components' => $tag->getComponents(),
                ])
            );
        } catch (\Twig_Error $e) {
            return new Response($e->getMessage(), 500);
        }
    }
}
