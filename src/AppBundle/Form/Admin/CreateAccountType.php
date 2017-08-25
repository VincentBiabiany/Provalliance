<?php

namespace AppBundle\Form\Admin;

use AppBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Doctrine\ORM\EntityRepository;

class CreateAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      $builder
            ->add('salon', EntityType::class, array(
                // query choices from this entity
                'class' => 'ApiBundle:Salon',
                // use the User.username property as the visible option string

                'choice_label' => 'nom',
                'label' => 'admin_create.nom',
                'translation_domain' => 'admin_create'
              ))
              ->add('personnel', NumberType::class, array(
                  'label' => 'admin_create.personnel',
                  'translation_domain' => 'admin_create'
                ))
            ->add('Envoyer', SubmitType::class, array(
                'label' => 'admin_create.envoyer',
                'attr' => array('class' =>'btn-black end'),
                'translation_domain' => 'admin_create'
              ))
        ;
    }

	public function configureOptions(OptionsResolver $resolver)
	{
	// 	$resolver->setDefaults(array(
	// 		'data_class' => DemandeAcompte::class,
    //   'idSalon' => null
	// 	));
	}
}
