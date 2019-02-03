<?php

namespace App\Form\DataTransformer;

use App\Utils\Slugger;
use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * This data transformer is used to translate the array of tags into a comma separated format
 * that can be displayed and managed by Bootstrap-tagsinput js plugin (and back on submit).
 *
 * See https://symfony.com/doc/current/form/data_transformers.html
 *
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 * @author Jonathan Boyer <contact@grafikart.fr>
 */
class TagArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * @var Tag[]|array
     */
    private $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($tags): string
    {
        return \implode(',', $tags);
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($string): array
    {
        if ('' === $string || null === $string) {
            return [];
        }

        $names = \array_filter(\array_unique(\array_map('trim', \explode(',', $string))));

        $databaseTags = $this->tags->findBy([
            'name' => $names,
        ]);

        $newNames = \array_diff($names, $databaseTags);
        foreach ($newNames as $name) {
            $tag = new Tag();
            $tag->setName($name);
            $tag->setSlug(Slugger::slugify($name));
            $databaseTags[] = $tag;
        }

        return $databaseTags;
    }
}
