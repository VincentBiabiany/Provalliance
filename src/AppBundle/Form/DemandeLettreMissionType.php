<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeLettreMission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DemandeLettreMissionType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $idSalon = $options["idSalon"];
    $builder->add('matricule', EntityType::class, array(
                  // query choices from this entity
                  'class' => 'ApiBundle:Personnel',
                  // use the User.username property as the visible option string

                  'choice_label' => function ($personnel) {
                        return $personnel->getNom() ." ". $personnel->getPrenom();
                      },

                  'query_builder' => function (EntityRepository $er) use ($idSalon) {
                      return $er->findActivePersonnelBySalon($idSalon);
                    },
                  'label' => 'demandeacompte.nom',
                  'translation_domain' => 'demande_acompte'
              ))
            ->add('sage', EntityType::class, array(
                  // query choices from this entity
                  'class' => 'ApiBundle:Salon',
                  // use the User.username property as the visible option string

                  'choice_label' => function ($salon) {
                        return $salon->getAppelation();
                      },
                  'query_builder' => function (EntityRepository $er) {
                      return $er->findAllActiveSalon(true);
                    },
                  'label' => 'demandeacompte.nom',
                  'translation_domain' => 'demande_acompte'
              ))
            ->add('dateDebut', DateType::class, array(
              'widget' => 'choice',
              'format' => 'd/M/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'attr' => ['class' => 'until'],
              'label' => ' '
            ))
            ->add('dateFin', DateType::class, array(
              'widget' => 'choice',
              'format' => 'd/M/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'attr' => ['class' => 'until'],
              'label' => ' ',
            ))
            ->add('raison', ChoiceType::class, array(
              'choices' => array(
                'embauche.cdd.surcroit'  => 'embauche.cdd.surcroit',
                'embauche.cdd.rempla' => 'embauche.cdd.rempla',
                'embauche.cdd.renouv' => 'embauche.cdd.renouv',
              ),
              'choice_translation_domain' => 'embauche',
              'translation_domain' => 'embauche',
              'expanded' => true,
              'multiple' => false,
            ))
            ->add('tempsPartiel', CollectionType::class,[
                  'entry_type' => NumberType::class,'translation_domain' => 'embauche'])
            ->add('Envoyer', SubmitType::class, array(
              'label' => 'embauche.send',
              'attr' => array('class' =>'btn-black end'),
              'translation_domain' => 'embauche',
            ));
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => DemandeLettreMission::class,
      'allow_extra_fields' => true,
      'idSalon' => null,
    ));
  }
}
