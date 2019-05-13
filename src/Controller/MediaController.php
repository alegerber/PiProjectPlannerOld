<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MediaController extends AbstractController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(
        \Twig_Environment $twig
    ) {
        $this->twig = $twig;
    }

    /**
     * @Route("/media", methods={"GET"}, name="media")
     *
     * @return Response
     *
     * @throws \Twig_Error
     */
    public function index(): Response
    {
        /**
         * @var Media[]
         */
        $media = $this->getDoctrine()
            ->getRepository(Media::class)->findAll();

        return new Response(
            $this->twig->render('05-media/media.html.twig', [
                'media' => $media,
            ])
        );
    }
}
