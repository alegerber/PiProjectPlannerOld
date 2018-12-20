<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tag;
use App\Entity\Component;
use App\Interfaces\JsonDatafields;
use App\Traits\JsonArrayToArrayClasses;

class TagController extends AbstractController implements JsonDatafields
{
    use JsonArrayToArrayClasses;

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

        $this->components = $this->getArrayClasses(
            $this->tag->getComponents(),
            $this->getDoctrine()->getRepository(Component::class)
        );

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $this->tag,
            'components' => $this->components,
        ]);
    }
}
