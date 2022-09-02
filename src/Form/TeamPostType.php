<?php

namespace App\Form;

use App\Entity\TeamPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('link', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien vers un autre site'
                )
            ])
            ->add('youtubeLink', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien de votre vidéo youtube'
                )
            ])
            ->add('content', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Ecrivez votre message...'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TeamPost::class,
        ]);
    }
}
