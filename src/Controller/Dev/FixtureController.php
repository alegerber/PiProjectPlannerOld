<?php

namespace App\Controller\Dev;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Entity\Component;
use App\Entity\Image;
use App\Entity\Project;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;

class FixtureController extends AbstractController
{
    /**
     * @var Image[]
     */
    private $images;

    /**
     * @var Tag[]
     */
    private $tags;

    /**
     * @Route("/dev/{slug}", name="dev")
     */
    public function index($slug)
    {
        if ($_SERVER['APP_ENV'] === 'dev' && $slug === 'kd0lK8KUV5rDGby7iCfzLXkATSzBxq') {
            $entityManager = $this->getDoctrine()->getManager();

            $this->categories = $this->getDoctrine()
            ->getRepository(Category::class)->findAll();
            
            $this->components = $this->getDoctrine()
            ->getRepository(Component::class)->findAll();

            $this->images = $this->getDoctrine()
            ->getRepository(Image::class)->findAll();
             
            $this->projects = $this->getDoctrine()
            ->getRepository(Project::class)->findAll();

            $this->tags = $this->getDoctrine()
            ->getRepository(Tag::class)->findAll();
            
            $lengthCategory = \count($this->categories) - 1;

            $lengthComponent = \count($this->components) - 1;

            $lengthImage = \count($this->images) - 1;

            $lengthTag = \count($this->tags) - 1;

            foreach ($this->images as $image) {
                for ($i = 0; $i < 7; ++$i) {
                    $image->addTag($this->tags[\mt_rand(0, $lengthTag)]);
                }
                $entityManager->persist($image);
            }

            foreach ($this->components as $component) {
                for ($i = 0; $i < 7; ++$i) {
                    $component->addTag($this->tags[\mt_rand(0, $lengthTag)]);
                    $component->addCategory($this->categories[\mt_rand(0, $lengthCategory)]);
                }
                $component->setImage($this->images[\mt_rand(0, $lengthImage)]);
                $entityManager->persist($component);
            }

            foreach ($this->projects as $project) {
                for ($i = 0; $i < 7; ++$i) {
                    $project->addTag($this->tags[\mt_rand(0, $lengthTag)]);
                    $project->addCategory($this->categories[\mt_rand(0, $lengthCategory)]);
                    $project->addComponent($this->components[\mt_rand(0, $lengthComponent)]);
                }
                $project->setImage($this->images[\mt_rand(0, $lengthImage)]);
                $entityManager->persist($project);
            }
            
            $entityManager->flush();

            return new Response('<html><body>OK<body></html>');
        } else {
            return new Response('<html><body>wrong password<body></html>');
        }
    }
}
