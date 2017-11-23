<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeAbsencesInjustifiees;
use AppBundle\Entity\Retards;
use AppBundle\Form\RetardsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;



class DemandeAbsencesInjustifieesType extends AbstractType
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
                  'label' => '___demande_absences.collaborateur',
                  'translation_domain' => 'translator',
                  'attr' => ['required' => 'required']
              ))
            ->add('dateDebut', DateType::class, array(
              'widget' => 'choice',
              'format' => 'dd/MM/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'attr' => ['class' => ''],
              'label' => '',
              'data' => new \DateTime()

            ))
            ->add('raison', ChoiceType::class, array(
              'choices' => array(
                '___demande_absences.abs'      => '___demande_absences.abs',
                '___demande_absences.absLes'   => '___demande_absences.absLes',
                '___demande_absences.retards'  => '___demande_absences.retards',
              ),
              'choice_translation_domain' => 'translator',
              'translation_domain' => 'translator',
              'expanded' => true,
              'multiple' => false,
            ))
            ->add('retards',CollectionType::class, array(
              'entry_type'     => RetardsType::class,
              'entry_options'  => array(
                  'attr'       => array('class' => 'email-box sousLabel'),
              ),
              'allow_add'      => true,
              'allow_delete'   => true
            ))
            ->add('absences',CollectionType::class, array(
              'entry_type'   => DateType::class,
              'entry_options'  => array(
                  'attr'       => array('class' => 'styleDate sousLabel listAbsence'),
                  'widget' => 'choice',
                  'format' => 'dd/MM/y',
                  'years' => range(date('Y') - 5, date('Y') + 10),
                  'data' => new \DateTime()

              ),
              'allow_add'      => true,
              'allow_delete'   => true
            ))
            ->add('Envoyer', SubmitType::class, array(
              'label' => 'global.submit',
              'attr' => array('class' =>'btn-black end'),
              'translation_domain' => 'translator',
            ))
            ->addEventListener(FormEvents::POST_SUBMIT,
                function(FormEvent $event)
                {
                  $form = $event->getForm();
                  $data = $event->getForm()->getData();

                  $data->setMatricule($form['matricule']->getData()->getMatricule());

                  $raison = $data->getRaison();
                  if ($raison == '___demande_absences.abs') {

                    $data->setAbsences(null);
                    $data->setRetards(null);

                  } else if ($raison == '___demande_absences.absLes') {

                    $data->setRetards(null);

                  } else {

                    $data->setAbsences(null);
                  }

                  $event->setData($data);
              });
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => DemandeAbsencesInjustifiees::class,
      'allow_extra_fields' => true,
      'idSalon' => null,
    ));
  }
}
