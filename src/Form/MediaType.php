<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('uploadedfile', FileType::class)
            ->add('name', TextType::class)
            ->add('slug', TextType::class)
            ->add('description', TextareaType::class)
            ->add('thumbnail', Image::class)
            // ->add('projects', ChoiceType::class, [
            //     'required' => false,
            // ])
            // ->add('categories', ChoiceType::class, [
            //     'required' => false,
            // ])
            // ->add('tags', ChoiceType::class, [
            //     'required' => false,
            // ])
            // ->add('components', ChoiceType::class, [
            //     'required' => false,
            // ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
