<?php

namespace AppBundle\Form\Admin;

use AppBundle\Entity\User;
use ApiBundle\Entity\Personnel;
use ApiBundle\Entity\Salon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ApiBundle\Repository\PersonnelRepository;


class CreateAccountType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    //   $builder = $this->container->get('fos_user.registration.form.factory');

      $builder->add('salon', EntityType::class, array(
             'class' => 'ApiBundle:Salon',
             'choice_label' => 'nom',
             'label' => 'admin_create.nom',
             'placeholder' => ' Choisir un salon',
             'translation_domain' => 'admin_create'
         ))
         ->add('username', TextType::class, array(
                   'label'  => ('Nom d\'Utilisateur')
                          ))
         ->add('email', EmailType::class, array(
                   'label'  => ('Email')
                          ))
         ->add('plainPassword', RepeatedType::class, array(
                    'type'  =>  PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                            ))

        ->add('enabled', ChoiceType::class, array(
                  'choices'  => array('Activer' => 1,'Desactiver' => 0),
                         'expanded' => true,
                         'multiple' => false))
        ->add('Valider', SubmitType::class, array(
               'label' => 'Créer un utilisateur',
               'translation_domain' => 'FOSUserBundle',
               'attr' => array(
                      'class' => 'btn btn-primary'
                       )
                      )
                 );



    }

	public function configureOptions(OptionsResolver $resolver)
	{
	}
}
