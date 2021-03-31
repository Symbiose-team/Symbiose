<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Conversation;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;

class Conversation1Type extends AbstractType
{      /**
    * @var Security
    */
   private $security;

   public function __construct(Security $security)
   {
      $this->security = $security;
   }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
  
        $builder
        ->add('User2', EntityType::class, [
            'class' => User::class,
            'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository->createQueryBuilder('gv')
                    ->where('gv.Email != :defaultGroup')
                    ->setParameters(['defaultGroup' => $this->security->getUser()->getEmail()]);
            },
            'choice_label' => 'username',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Conversation::class,
        ]);
    }
}
