<?php

namespace App\Form\DataTransformer;

use App\Repository\ComponentRepository;
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
class ComponentArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * @var Component[]|array
     */
    private $components;

    public function __construct(ComponentRepository $components)
    {
        $this->components = $components;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($components): string
    {
        return \implode(',', $components);
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

        return $this->components->findBy([
            'name' => $names,
        ]);
    }
}
