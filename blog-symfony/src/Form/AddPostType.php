<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostCategory;
use App\Utils\Generic\ArrayServicesGeneric;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPostType extends AbstractType
{

    const REQUIRED_ATTRIBUTES = ["postcategory"];


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        if( key_exists("attr",$options) ) {
            ArrayServicesGeneric::allKeysAreInArray( self::REQUIRED_ATTRIBUTES, $options["attr"] );
        }


        $builder
            ->add('state')
            ->add('title', TextType::class, ["required" => true, "label" => "Titre de l'article"])
            ->add('headcontent', TextareaType::class, ["required" => true, "label" => "Entête"])
            ->add('content', TextareaType::class, ["required" => true, "label" => "Contenu de l'article"])
            ->add('id_post_category', EntityType::class, [
                "required" => true,
                "class" => PostCategory::class,
                "choices" => []
            ] )
            ->add('submit', SubmitType::class, ["label" => "Ajouter l'article"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'csrf_protection' => false
        ]);
    }


}
