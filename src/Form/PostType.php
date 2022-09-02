<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Workout;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => array(
                    'placeholder' => 'que souhaitez vous dire?'
                )
            ])
            ->add('images', Filetype::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->add('link', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => array(
                    'placeholder' => 'un lien vers un site externe'
                )
            ])
            ->add('youtubeLink', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'lien de votre vidéo Youtube'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
