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
use AppBundle\Service\FileUploader;


class DemandeLettreMissionType extends AbstractType
{
  private $fileUploader;

  public function __construct(FileUploader $fileUploader)
  {
  $this->fileUploader = $fileUploader;
  }
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
                  'label' => 'lettre_mission.nom',
                  'translation_domain' => 'translator',
                  'attr' => ['required' => 'required']
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
                  'label' => 'lettre_mission.salon',
                  'translation_domain' => 'translator'
              ))
            ->add('dateDebut', DateType::class, array(
              'widget' => 'choice',
              'format' => 'dd/MM/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'attr' => ['class' => ''],
              'label' => '',
              'data' => new \DateTime()

            ))
            ->add('dateFin', DateType::class, array(
              'widget' => 'choice',
              'format' => 'dd/MM/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'attr' => ['class' => ''],
              'label' => '',
              'data' => new \DateTime()

            ))
            ->add('raison', ChoiceType::class, array(
              'choices' => array(
                'lettre_mission.35h'   => 'lettre_mission.35h',
                'lettre_mission.xh'    => 'lettre_mission.xh',
                'lettre_mission.depla' => 'lettre_mission.depla',
              ),
              'choice_translation_domain' => 'translator',
              'translation_domain' => 'translator',
              'expanded' => true,
              'multiple' => false,
            ))
            ->add('tempsPartiel', CollectionType::class,
                [
                  'entry_type' => NumberType::class,
                  'translation_domain' => 'translator'
                ]
            )
            ->add('Envoyer', SubmitType::class, array(
              'label' => 'lettre_mission.envoyer',
              'attr' => array('class' =>'btn-black end'),
              'translation_domain' => 'translator',
            ))
            ->addEventListener(FormEvents::POST_SUBMIT,
                function(FormEvent $event)
                {
                  $form = $event->getForm();
                  $data = $event->getForm()->getData();

                  if ($data->getRaison() == "lettre_mission.depla")
                    $data->setSage($form['sage']->getData()->getSage());
                  else
                    $data->setSage(null);

                  $data->setMatricule($form['matricule']->getData()->getMatricule());
                  $event->setData($data);
              });
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
