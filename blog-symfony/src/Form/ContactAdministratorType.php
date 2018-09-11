<?php

namespace App\Form;

use App\Entity\ValueObject\ContactAdministratorForm;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactAdministratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ["required" => true,"label" => "Votre adresse email"])
            ->add('subject', TextType::class, ["required" => true, "label" => "Sujet de votre message"])
            ->add('message',TextareaType::class, ["required" => true, "label" => "Votre message"])
            ->add('submit',SubmitType::class,[
                "label" => "Envoyer votre message",
                "attr" => array("class" => "btn-block")
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => ContactAdministratorForm::class
        ]);
    }
}
