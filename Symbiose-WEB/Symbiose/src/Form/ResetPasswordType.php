<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{

    public function Configuration($label, $placeholder, $options = [])
    {
        return array_merge([
            'label' => $label,
            'attr' => ['placeholder' => $placeholder]
        ], $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("newPassword", PasswordType::class, $this->Configuration("Nouveau mot de passe", "Tapez votre nouveau mot de passe"))
            ->add("confirmPassword", PasswordType::class, $this->Configuration("Confirmation du mot de passe", "Confirmez votre nouveau mot de pasee"));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>User::class
        ]);
    }
}