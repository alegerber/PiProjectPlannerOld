<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Component;
use App\Entity\Image;
use App\Entity\Project;
use App\Entity\Tag;
use App\Utils\Slugger;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectManager;

class EntityFixtures
{
    public function getProject(ObjectManager $manager, int $entries): Project
    {
        $project = new Project();
        $name = 'project ' . \random_int(0, $entries);
        $project->setName($name);
        $project->setSlug(
            Slugger::slugify($name)
        );
        $project->setDescription('Some Random Text ' . \random_int(0, $entries));

        $tagAll = $manager->getRepository(Tag::class)->findAll();

        $length = \count($tagAll) - 1;

        $project->addTag(
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)]
        );

        $categoryAll = $manager->getRepository(Category::class)->findAll();

        $length = \count($categoryAll) - 1;

        $project->addCategory(
            $categoryAll[\random_int(0, $length)],
            $categoryAll[\random_int(0, $length)],
            $categoryAll[\random_int(0, $length)],
            $categoryAll[\random_int(0, $length)]
        );

        $componentAll = $manager->getRepository(Component::class)->findAll();

        $length = \count($componentAll) - 1;

        $project->addComponent(
            $componentAll[\random_int(0, $length)],
            $componentAll[\random_int(0, $length)],
            $componentAll[\random_int(0, $length)],
            $componentAll[\random_int(0, $length)]
        );

        $imageAll = $manager->getRepository(Image::class)->findAll();

        $length = \count($imageAll) - 1;

        $project->setImage(
            $imageAll[\random_int(0, $length)]
        );

        return $project;
    }

    public function getComponent(ObjectManager $manager, int $entries): Component
    {
        $component = new Component();
        $name = 'component ' . \random_int(0, $entries);
        $component->setName($name);
        $component->setSlug(
            Slugger::slugify($name)
        );
        $component->setDescription('Some Random Text ' . \random_int(0, $entries));

        $tagAll = $manager->getRepository(Tag::class)->findAll();

        $length = \count($tagAll) - 1;

        $component->addTag(
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)]
        );

        $categoryAll = $manager->getRepository(Category::class)->findAll();

        $length = \count($categoryAll) - 1;

        $component->addCategory(
            $categoryAll[\random_int(0, $length)],
            $categoryAll[\random_int(0, $length)],
            $categoryAll[\random_int(0, $length)],
            $categoryAll[\random_int(0, $length)]
        );

        $imageAll = $manager->getRepository(Image::class)->findAll();

        $length = \count($imageAll) - 1;

        $component->setImage(
            $imageAll[\random_int(0, $length)]
        );

        return $component;
    }

    public function getImage(ObjectManager $manager, int $entries): Image
    {
        $image = new Image();

        $image->setUploadedFile(
            new UploadedFile('/var/www/html/public/img/placeholder.jpg', 'bildschirmfoto.jpg')
        );

        $image->setName('image ' . \random_int(0, $entries));
        $image->setDescription('Some Random Text ' . \random_int(0, $entries));

        $tagAll = $manager->getRepository(Tag::class)->findAll();

        $length = \count($tagAll) - 1;

        $image->addTag(
            $tagAll[\random_int(0, $length)],
            $tagAll[\random_int(0, $length)]
        );

        return $image;
    }

    public function getCategory(int $entries): Category
    {
        $category = new Category();
        $name = 'category ' . \random_int(0, $entries);
        $category->setName($name);
        $category->setSlug(
            Slugger::slugify($name)
        );

        return $category;
    }

    public function getTag(int $entries): Tag
    {
        $tag = new Tag();
        $name = 'tag ' . \random_int(0, $entries);
        $tag->setName($name);
        $tag->setSlug(
            Slugger::slugify($name)
        );
        return $tag;
    }
}