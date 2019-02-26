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
     * @var ObjectManager $manager
     */
    private $manager;

    /**
     * @var int $entrys
     */
    private $entrys;

    /**
     * @param ObjectManager $manager
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
            $name = 'project ' . \random_int(0, $this->entrys);
            $project->setName($name);
            $project->setSlug(
                Slugger::slugify($name)
            );
            $project->setDescription('Some Random Text ' . \random_int(0, $this->entrys));

            $tags = $this->manager->getRepository(Tag::class)->findAll();
            $project->addTag(\array_rand($tags, 4));

            $categories = $this->manager->getRepository(Category::class)->findAll();
            $project->addCategory(\array_rand($categories, 4));

            $components = $this->manager->getRepository(Component::class)->findAll();
            $project->addComponent(\array_rand($components, 4));

            $images = $this->manager->getRepository(Image::class)->findAll();
            $project->setImage(\array_rand($images, 1));

            $this->manager->persist($project);
        }
    }

    public function getOrder(): int
    {
        return 3;
    }
}
