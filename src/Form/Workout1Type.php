<?php

namespace App\Form;

use App\Entity\Difficulty;
use App\Entity\ExercicePerso;
use App\Entity\MuscleGroup;
use App\Entity\SportsList;
use App\Entity\Workout;
use App\Repository\SportsListRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Workout1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false
            ])
            ->add('rounds', TextType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => false
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
            ])
            ->add('exercicePersos', CollectionType::class, [
                'entry_type' => ExercicePersoType::class,
                'label' => 'Exercice',
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workout::class,
        ]);
    }
}
