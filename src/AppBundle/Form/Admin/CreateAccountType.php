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
use Symfony\Component\HttpFoundation\Request;


class CreateAccountType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

      $builder->add('salon', EntityType::class, array(
             'class' => 'ApiBundle:Salon',
             'choice_label' => 'nom',
             'label' => 'admin_create.nom',
             'placeholder' => ' Choisir un salon',
             'translation_domain' => 'admin_create'
         ));




                 $formModifier = function (FormInterface $form, $salon = null) {

                       $personnels= array();
                            // var_dump('salon:'.$salon);
                           $form->add('personnel', EntityType::class, array(
                               'class' => 'ApiBundle:Personnel',
                               'choices' => $personnels,
                           ));
                       };

                       $builder->addEventListener(
                           FormEvents::PRE_SET_DATA,
                           function (FormEvent $event) use ($formModifier) {
                               // this would be your entity, i.e. SalonMeetup
                               $data = $event->getData();
$salon2 =22;

var_dump($event);
                               $formModifier($event->getForm(),  $salon2);

                           }
                       );

                       $builder->get('salon')->addEventListener(
                           FormEvents::POST_SUBMIT,
                           function (FormEvent $event) use ($formModifier) {
                               // It's important here to fetch $event->getForm()->getData(), as
                               // $event->getData() will get you the client data (that is, the ID)
                               $salon = $event->getForm()->getData();

                               // since we've added the listener to the child, we'll have to pass on
                               // the parent to the callback functions!
                               $formModifier($event->getForm()->getParent(), $salon);
                           }
                       );


    }

	public function configureOptions(OptionsResolver $resolver)
	{
        $resolver->setRequired('idsalon');
	}
}
