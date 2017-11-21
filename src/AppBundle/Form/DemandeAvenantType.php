<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeAvenant;
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
use AppBundle\Service\FileUploader;


class DemandeAvenantType extends AbstractType
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
                '___avenant.partielTherap' => '___avenant.partielTherap',
                '___avenant.partielDef'    => '___avenant.partielDef',
                '___avenant.tempsPlein'    => '___avenant.tempsPlein',
                '___avenant.39h'           => '___avenant.39h',
                '___avenant.manager'       => '___avenant.manager',
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
            ->add('pieceJointe1', FileType::class, array(
              'translation_domain' => 'translator',
            ))
            ->add('pieceJointe2', FileType::class, array(
              'translation_domain' => 'translator',
            ))
            ->add('salaireFixe', NumberType::class, array(
              'translation_domain' => 'translator',
            ))
            ->add('salaireMens', NumberType::class, array(
              'translation_domain' => 'translator',
            ))
            ->add('salaireTrim', NumberType::class, array(
              'translation_domain' => 'translator',
            ))
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

                  $data->setMatricule($form['matricule']->getData()->getMatricule());
                  dump($data->getRaison());
                  if ($data->getRaison() != 'avenant.partielTherap' && $data->getRaison() != 'avenant.partielDef')
                  {
                    $data->setTempsPartiel(null);
                  }
                  else
                  {
                    $data->setDateFin(null);
                  }

                  if ($data->getRaison() != 'avenant.manager')
                  {
                    $data->setSalaireFixe(null);
                    $data->setSalaireMens(null);
                    $data->setSalaireTrim(null);
                  }

                  if ($data->getRaison() != 'avenant.manager' && $data->getRaison() != 'avenant.39h')
                  {
                    $fileName = $this->fileUploader->upload($data->getPieceJointe1(), $data->getMatricule(), 'demande_avenant', 'courrier');
                    $data->setPieceJointe1($fileName);
                  }
                  else
                  {
                    $data->setPieceJointe1(null);
                  }

                  if ($data->getRaison() == 'avenant.partielTherap')
                  {
                    $fileName = $this->fileUploader->upload($data->getPieceJointe2(), $data->getMatricule(), 'demande_avenant', 'courrier');
                    $data->setPieceJointe2($fileName);
                  }

                  $event->setData($data);
              });
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => DemandeAvenant::class,
      'allow_extra_fields' => true,
      'idSalon' => null,
    ));
  }
}
