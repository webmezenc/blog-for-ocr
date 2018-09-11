<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddOrEditPostType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', TextType::class, ["required" => true, "label" => "Titre de l'article"])
            ->add('state', ChoiceType::class, [
                "required" => true,
                "choices" => [
                    "Brouillon" => Post::POST_DRAFT,
                    "Publié" => Post::POST_PUBLISHED
                ],
                "label" => "Etat de publication"
            ])
            ->add('id_post_category', EntityType::class, [
                "required" => true,
                "by_reference" => false,
                "class" => PostCategory::class,
                "choices" => $options["postcategory"],
                "multiple" => false,
                "choice_label" => "name",
                "choice_value" => "id",
                "label" => "Catégorie"
            ] )
            ->add('headcontent', TextareaType::class, ["required" => true, "label" => "Entête", "attr" => [
                "rows" => 5
            ]])
            ->add('content', TextareaType::class, ["required" => true, "label" => "Contenu de l'article", "attr" => [
                "rows" => 30
            ]])
            ->add('submit', SubmitType::class, ["label" => "Sauvegarde l'article", "attr" =>
            [
                "class" => "btn-block"
            ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('postcategory');
        $resolver->setDefaults([
            'data_class' => Post::class,
            'csrf_protection' => false
        ]);
    }


}
