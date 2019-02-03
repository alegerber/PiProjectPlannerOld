<?php

namespace App\DataFixtures;

use App\Utils\Slugger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use App\Entity\Project;
use App\Entity\Component;
use App\Entity\Image;
use App\Entity\Tag;
use App\Entity\Category;

class ProjectFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @var int
     */
    private $entrys;

    /**
     * @param ObjectManager
     */
    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;

        $this->entrys = 100;

        $this->project();

        $this->manager->flush();
    }

    private function project(): void
    {
        for ($i = 0; $i <= $this->entrys; ++$i) {
            $project = new Project();
            $name = 'project '.\mt_rand(0, $this->entrys);
            $project->setName($name);
            $project->setSlug(
                Slugger::slugify($name)
            );
            $project->setDescription('Some Random Text '.\mt_rand(0, $this->entrys));

            $tagAll = $this->manager->getRepository(Tag::class)->findAll();

            $length = \count($tagAll) - 1;

            $project->addTag(
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)],
                $tagAll[\mt_rand(0, $length)]
            );

            $categoryAll = $this->manager->getRepository(Category::class)->findAll();

            $length = \count($categoryAll) - 1;

            $project->addCategory(
                $categoryAll[\mt_rand(0, $length)],
                $categoryAll[\mt_rand(0, $length)],
                $categoryAll[\mt_rand(0, $length)],
                $categoryAll[\mt_rand(0, $length)]
            );

            $componentAll = $this->manager->getRepository(Component::class)->findAll();

            $length = \count($componentAll) - 1;

            $project->addComponent(
                $componentAll[\mt_rand(0, $length)],
                $componentAll[\mt_rand(0, $length)],
                $componentAll[\mt_rand(0, $length)],
                $componentAll[\mt_rand(0, $length)]
            );

            $imageAll = $this->manager->getRepository(Image::class)->findAll();

            $project->setImage(
                $imageAll[\mt_rand(0, $length)]
            );

            $this->manager->persist($project);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
