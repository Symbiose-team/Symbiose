<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType{

    public function Configuration($label,$placeholder, $options=[]){
        return array_merge([
            'label'=> $label,
            'attr'=>['placeholder'=>$placeholder]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname',TextType::class,$this->Configuration("Nom & Prenom","Votre nom & prénom"))
            ->add('email',TextType::class,$this->Configuration("Email","Votre Email"))
            ->add('phone',TextType::class,$this->configuration("Numéro mobile","Votre numéro "))
            ->add('sujet',TextType::class,$this->Configuration("Sujet","Votre sujet"))
            ->add('message',TextareaType::class,$this->Configuration("Message","Votre adresse Message"));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}