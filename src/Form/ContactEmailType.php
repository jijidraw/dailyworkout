<?php

namespace App\Form;

use App\Entity\ContactEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => array(
                    'placeholder' => 'exemple...@domain.com'
                )
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'attr' => array(
                    'placeholder' => 'le sujet de votre message...'
                )
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => array(
                    'placeholder' => 'votre message...'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactEmail::class,
        ]);
    }
}
