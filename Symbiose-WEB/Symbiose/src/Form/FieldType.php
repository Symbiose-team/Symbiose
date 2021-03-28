<?php

namespace App\Form;

use App\Entity\Calendar;
use App\Entity\Field;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CalendarType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serialNumber')
            ->add('name')
            ->add('address')
            ->add('space')
            ->add('provider')
            ->add('price')
            ->add('status')
            ->add('Date_start',\Symfony\Component\Form\Extension\Core\Type\DateTimeType::class,[
                'attr'=>['class'=>'form-control js-datepicker'],
                    'widget'=>'single_text'
                ]
            )
            ->add('Date_end',\Symfony\Component\Form\Extension\Core\Type\DateTimeType::class,[
                'attr'=>['class'=>'form-control js-datepicker'],
                'widget'=>'single_text'

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Field::class,
        ]);
    }
}
