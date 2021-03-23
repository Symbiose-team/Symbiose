<?php

namespace App\Form;

use App\Entity\Lobby;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserjoinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       /* $builder
            ->add('users', EntityType::class, [
                'class'=>User::class ,
                'choice_label'=>'username'
            ] )

        ;*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lobby::class,
        ]);
    }
}
