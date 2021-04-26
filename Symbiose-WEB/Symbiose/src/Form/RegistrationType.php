<?php

namespace App\Form;

use App\Entity\User;
use libphonenumber\PhoneNumberFormat;
use Misd\PhoneNumberBundle\Form\Type\PhoneNumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    /**
     * Permet d'avoir la configuration de base d'un champ

     * @param $placeholder
     * @param $label
     * @param array $options
     * @return array
     */
    public function Configuration($label,$placeholder, $options=[]){
        return array_merge([
            'label'=> $label,
            'attr'=>['placeholder'=>$placeholder]
        ], $options);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->Configuration("Prénom","Votre prénom"))
            ->add('lastName',TextType::class,$this->Configuration("Nom","Votre nom de famille"))
            ->add('Email',EmailType::class,$this->Configuration("Email","Votre adresse email"))
            ->add('picture',UrlType::class,$this->Configuration("Photo","URL de votre avatar"))
            ->add('hash',PasswordType::class,$this->Configuration("Mot de passe","Entrez un bon mot de passe"))
            ->add('passwordConfirm',PasswordType::class,$this->Configuration("Confirmation de mot de passe","Veuillez confirmer votre mot de passe"))
            ->add('cin',NumberType::class,$this->Configuration("Cin","Votre numéro CIN"))
            ->add('birthday',DateType::class,['widget' => 'single_text'])
            ->add('genre', ChoiceType::class, [
                'choices' => ['Homme' => 'Homme', 'Femme' => 'Femme'],
                'expanded' => true,
                'multiple' => false
                ])
            ->add('role',ChoiceType::class,[
                'choices'  => [
                    'Fournisseur'=>"Fournisseur",
                    'Client' => "Client"

                ],
            ])
            ->add('adresse',TextType::class,$this->Configuration("Adresse","Votre adresse"))
            ->add('phoneNumber', NumberType::class,$this->Configuration("N° TEL","Votre numéro de telephone"));



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
