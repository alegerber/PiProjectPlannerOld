<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Media;
use App\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $this->twig->render('05-pages/media.html.twig', [
                'media' => $media,
            ])
        );
    }

    /**
     * @Route("/media/new", methods={"POST"}, name="media_new")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): JsonResponse
    {
        /** @var Media $media */
        $media = new Media();

        $form = $this->createForm(MediaType::class, $media);

        //@TODO slug
        $form->submit($request->getData());

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(\json_encode(true));
    }
}
