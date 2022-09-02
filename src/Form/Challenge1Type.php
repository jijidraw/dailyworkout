<?php

namespace App\Form;

use App\Entity\Challenge;
use App\Entity\Difficulty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Challenge1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'nom du challenge'
                )
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'description du challenge'
                )
            ])
            ->add('link', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien vers un site extérieur'
                )
            ])
            ->add('youtubeLink', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien d\'une vidéo youtube'
                )
            ])
            ->add('level', EntityType::class, [
                'class' => Difficulty::class,
                'label' => 'Choix d\'une difficulté'
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Challenge::class,
        ]);
    }
}
