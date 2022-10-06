<?php

namespace App\Form;

use App\Entity\UserPreference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPreferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_alcool', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_meditation', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_tabac', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_healthy', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_training', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_weight', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ])
            ->add('is_water', CheckboxType::class, [
                'label' => 'Oui',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserPreference::class,
        ]);
    }
}
