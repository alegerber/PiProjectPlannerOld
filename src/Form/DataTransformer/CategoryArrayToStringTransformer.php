<?php declare(strict_types = 1);

namespace App\Form\DataTransformer;

use App\Utils\Slugger;
use App\Entity\Category;
use App\Repository\CategoryRepository;
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
class CategoryArrayToStringTransformer implements DataTransformerInterface
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($categories): string
    {
        return \implode(',', $categories);
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

        $categories = $this->categoryRepository->findBy([
            'name' => $names,
        ]);

        $newNames = \array_diff($names, $categories);

        foreach ($newNames as $name) {
            $category = new Category();
            $category->setName($name);
            $category->setSlug(Slugger::slugify($name));
            $categories[] = $category;
        }

        return $categories;
    }
}
