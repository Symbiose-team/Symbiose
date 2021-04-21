<?php

namespace App\Form;

use App\Entity\EventSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'All' => '',
                    'Football' => 'Football',
                    'Basketball' =>'Basketball',
                    'Tennis' => 'Tennis',
                    'Paintball' => 'Paintball',
                    'LaserTag' => 'LaserTag',
                ],
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Event Name'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
