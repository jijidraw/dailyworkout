<?php

namespace App\Form;

use App\Entity\Difficulty;
use App\Entity\Workout;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'le nom de votre workout'
                )
            ])
            ->add('rounds', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'nombre de tours de votre entrainement'
                )
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'détails sur comment faire votre workout'
                )
            ])
            ->add('level', EntityType::class, [
                'class' => Difficulty::class,
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }
}
