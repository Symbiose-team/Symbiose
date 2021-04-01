<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('Description', TextareaType::class)
            ->add('Price')
            ->add('Type', ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('State', null, [
                'label' => 'In Stock'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Product::ARTICLE;
        $output = [];
        foreach ($choices as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
