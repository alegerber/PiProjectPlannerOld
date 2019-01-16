<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Project;
use App\Repository\ComponentRepository;

class ProjectType extends AbstractType
{
    /**
     * @var ComponentRepository
     */
    private $componentRepository;

    public function __construct(ComponentRepository $componentRepository)
    {
        $this->componentRepository = $componentRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', ImageType::class)
            ->add('categories', CollectionType::class, [
                'entry_type' => CategoryType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('tags', CollectionType::class, [
                'entry_type' => TagType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('components', CollectionType::class, [
                'entry_type' => ChoiceType::class,
                'entry_options' => [
                    'label' => false,
                    'choices' => $this->componentRepository->findAll(),
                    'choice_label' => function ($component, $key, $value) {
                        /* @var App\Entity\Component $component */
                        return $component->getTitle();
                    },
                    'choice_attr' => function ($component, $key, $value) {
                        return ['class' => 'component_'.strtolower($component->getTitle())];
                    },
                ],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Create',
                'attr' => ['class' => 'btn btn-default'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
