<?php

namespace App\Form;

use App\Entity\Reward;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RewardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'Nom du trophée'
                )
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => array(
                    'placeholder' => 'Description du trophée'
                )
            ])
            ->add('imageSystem', FileType::class, [
                'label' => 'image du trophée',
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reward::class,
        ]);
    }
}
