<?php

namespace App\Form;

use App\Entity\Difficulty;
use App\Entity\SportsList;
use App\Entity\Workout;
use App\Repository\SportsListRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Length;
use Webmozart\Assert\Assert;

class WorkoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Le nom de ton workout'
                )
            ])
            ->add('rounds', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Nombre de tours'
                )
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Commentaires éventuels sur ton entraînement'
                )
            ])
            ->add('level', EntityType::class, [
                'class' => Difficulty::class,
                'label' => false
            ])
            ->add('sport', EntityType::class, [
                'class' => SportsList::class,
                'query_builder' => function (SportsListRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                },
                'label' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }
}
