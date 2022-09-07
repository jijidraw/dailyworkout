<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Exercice;
use App\Entity\MuscleGroup;
use App\Entity\SportsList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('urlvideo')
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('muscleGroup', EntityType::class, [
                'class' => MuscleGroup::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('sports', EntityType::class, [
                'class' => SportsList::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('imageSystem', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
