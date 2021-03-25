<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name',TextType::class,array('attr' => array('class'=> 'form-control')))
            ->add('Supplier',TextType::class,array('required'=>false,
                'attr' => array('class'=>'form-control')))
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'Football' => 'Football',
                    'Basketball' =>'Basketball',
                    'Tennis' => 'Tennis',
                    'Paintball' => 'Paintball',
                    'LaserTag' => 'LaserTag',
                ],
            ])
            //TODO date should be greater or equal from today
            ->add('Date',DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('Picture', FileType::class, [
                'data_class' => null,
                'required' => true,
                'label' => 'Please upload this file',
                'mapped' => true,
                'constraints' => [
                    new Image(['maxSize' => '1024k'])
                ],
            ])
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
