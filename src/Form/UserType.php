<?php

namespace App\Form;

use App\Entity\Goal;
use App\Entity\SportsList;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => array(
                    'placeholder' => 'le nom sous lequel vous apparaissez'
                )
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Ma description',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'mettez un description de qui vous êtes'
                )
            ])
            ->add('urlInstagram', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien de votre compte Instagram'
                )
            ])
            ->add('urlFacebook', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien de votre compte facebook'
                )
            ])
            ->add('urlTwitter', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien de votre compte twitter'
                )
            ])
            ->add('urlTikTok', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien de votre compte tiktok'
                )
            ])
            ->add('sportlist', EntityType::class, [
                'label' => false,
                'class' => SportsList::class,
                'multiple' => true,
                'expanded' => true
            ])
            // ->add('sex', ChoiceType::class, array(
            //     'choices' => array(
            //         'Male' => 'male',
            //         'Female' => 'female',
            //         'SherHer' => 'sheher'
            //     )
            // ))
            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
