<?php

namespace App\Form;

use App\Entity\DiaryNote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiaryNoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weight', IntegerType::class, [
                'label' => 'Ton poids',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Si tu souhaites noter ton poid'
                )
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Tu peux noter ici tout ce que tu veux...'
                )
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('cheatmeal', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            // ->add('tabac', IntegerType::class, [
            //     'required' => false,
            //     'label' => false
            // ])
            ->add('alcool', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_meditation', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_water', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('training', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DiaryNote::class,
        ]);
    }
}
