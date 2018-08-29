<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('state')
            ->add('slug', TextType::class)
            ->add('title', TextType::class, ["required" => true, "label" => "Titre de l'article"])
            ->add('headcontent', TextareaType::class, ["required" => true, "label" => "Entête"])
            ->add('content', TextareaType::class, ["required" => true, "label" => "Contenu de l'article"])
            ->add('id_post_category')
            ->add('submit', SubmitType::class, ["required" => true, "label" => "Ajouter l'article"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
