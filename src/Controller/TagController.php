<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ComponentRepository;
use App\Entity\Component;
use App\Repository\TagRepository;
use App\Entity\Tag;
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
     * @var ComponentRepository
     */
    private $componentRepository;

    /**
     * @var TagRepository
     */
    private $tagRepository;

    public function __construct(
        TagRepository $tagRepository,
        ComponentRepository $componentRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->componentRepository = $componentRepository;
    }

    /**
     * @Route("/tag/{slug}", name="tag")
     */
    public function index($slug)
    {
        $this->tag = $this->tagRepository->findOneBy([
            'component_link' => $slug,
        ]);

        $this->components = $this->getArrayClasses(
            $this->tag->getComponents(),
            $this->componentRepository
        );

        return $this->render('05-pages/tag.html.twig', [
            'tag' => $this->tag,
            'components' => $this->components,
        ]);
    }
}
