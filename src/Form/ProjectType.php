<?php declare(strict_types = 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Project;
use App\Form\Type\TagsInputType;
use App\Form\Type\CategoriesInputType;
use App\Form\Type\ComponentsInputType;

class ProjectType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', ImageType::class, [
                'required' => false,
            ])
            ->add('tags', TagsInputType::class, [
                'required' => false,
            ])
            ->add('categories', CategoriesInputType::class, [
                'required' => false,
            ])
            ->add('components', ComponentsInputType::class, [
                'required' => false,
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
