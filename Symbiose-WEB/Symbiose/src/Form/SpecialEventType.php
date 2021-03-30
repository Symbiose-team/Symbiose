<?php

namespace App\Form;

use App\Entity\SpecialEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SpecialEventType extends AbstractType
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
            ->add('Date', DateTimeType::class, [
                'placeholder' => [
                    'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    'hour' => 'Hour', 'minute' => 'Minute', 'second' => 'Second',
                ]])
            ->add('State', CheckboxType::class, ['required' => true])
            ->add('imageFile', VichImageType::class, array('required'=>true,
                'attr' => array('class'=>'form-control')))
            ->add('save',SubmitType::class, array('label'=>'Create',
                'attr'=>array('class'=>'btn btn-primary mt-3')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SpecialEvent::class,
        ]);
    }
}
