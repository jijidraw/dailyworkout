<?php

namespace App\Form;

use App\Entity\EffortType;
use App\Entity\Exercice;
use App\Entity\ExercicePerso;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExercicePersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('EffortType', ChoiceType::class, array(
                'choices' => array(
                    'Reps' => 'reps',
                    'Min' => 'min',
                    'Sec' => 'sec',
                    'Km' => 'km',
                    'M' => 'm'
                )
            ))
            ->add('Rest', ChoiceType::class, array(
                'choices' => array(
                    '30 secs' => '30 secs',
                    '1 min' => '1 min',
                    '2 min' => '2 min',
                    '3 min' => '3 min',
                    '4 min' => '4 min',
                    '5 min' => '5 min',
                    'Repos minimum' => 'repos minimum',
                )
            ))
            ->add('content');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExercicePerso::class,
        ]);
    }
}
