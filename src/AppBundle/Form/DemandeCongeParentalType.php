<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeCongeParental;
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

class DemandeCongeParentalType extends AbstractType
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
              'label' => ''
            ))
            ->add('dateFin', DateType::class, array(
              'widget' => 'choice',
              'format' => 'dd/MM/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'attr' => ['class' => ''],
              'label' => '',
            ))
            ->add('raison', ChoiceType::class, array(
              'choices' => array(
                'conge_parental.passage' => 'conge_parental.passage',
                'conge_parental.reprise' => 'conge_parental.reprise',
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
            ->add('pieceJointe', FileType::class, array(
              'label' => 'conge_parental.lettre',
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
                  
                  $fileName = $this->fileUploader->upload($data->getPieceJointe(), $data->getMatricule(), 'demande_conge_parental', 'lettre');
                  $data->setPieceJointe($fileName);

                  if ($data->getRaison() != "conge_parental.passage")
                    $data->setTempsPartiel(null);

                  $data->setMatricule($form['matricule']->getData()->getMatricule());
                  $event->setData($data);
              });
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => DemandeCongeParental::class,
      'allow_extra_fields' => true,
      'idSalon' => null,
    ));
  }
}
