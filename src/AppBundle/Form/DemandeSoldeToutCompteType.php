<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeSoldeToutCompte;
use AppBundle\Form\DemandeSoldeToutCompteType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;


class DemandeSoldeToutCompteType extends AbstractType
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
      $this->fileUploader = $fileUploader;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $idSalon = $options["idSalon"];
      $matricule = $options["matricule"];

       $builder
              ->add('matricule', EntityType::class, array(
                  // query choices from this entity
                  'class' => 'ApiBundle:Personnel',
                  // use the User.username property as the visible option string

                  'choice_label' => function ($personnel) {
                        return $personnel->getNom() ." ". $personnel->getPrenom();
                      },

                  'query_builder' => function (EntityRepository $er) use ($idSalon) {
                      return $er->findActivePersonnelBySalon($idSalon);
                    },
                  'label' => 'demande_solde_tout_compte.collab',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-control','required' => 'required']
                ))
                ->add('adresse', TextType::class, array(
                     'label' => 'demande_solde_tout_compte.adresse',
                     'translation_domain' => 'translator',
                     'attr' => ['class' => 'form-control']
                ))
                ->add('dateSortie', DateType::class, array(
                'widget' => 'choice',
                'format' => 'dd/MM/y',
                'years' => range(date('Y') - 100, date('Y') - 20),
                'attr' => ['class' => 'form-control styleDate','name'=>'date']
                ))
                ->add('dateDernierJour', DateType::class, array(
                'label' => 'demande_solde_tout_compte.dateDernierJour',
                'widget' => 'choice',
                'format' => 'dd/MM/y',
                'years' => range(date('Y') - 100, date('Y') - 20),
                'attr' => ['class' => 'form-control styleDate','name'=>'date']
                ))
                ->add('motif', ChoiceType::class, array(
                  'choices'  => array(
                    'demande_solde_tout_compte.preavis'  => 'demande_solde_tout_compte.preavis',
                    'demande_solde_tout_compte.rpeEmploye' => 'demande_solde_tout_compte.rpeEmploye',
                    'demande_solde_tout_compte.rpeSalarie' => 'demande_solde_tout_compte.rpeSalarie',
                    'demande_solde_tout_compte.finCdd' => 'demande_solde_tout_compte.finCdd',
                    'demande_solde_tout_compte.ruptureAnticipe' => 'demande_solde_tout_compte.ruptureAnticipe',
                    'demande_solde_tout_compte.mutation' => 'demande_solde_tout_compte.mutation',
                    'demande_solde_tout_compte.retraite' => 'demande_solde_tout_compte.retraite',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-controlList labelRadioStyle'],
                  'label' => 'demande_solde_tout_compte.motif',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('typeAbsence', ChoiceType::class, array(
                  'choices'  => array(
                    'demande_solde_tout_compte.arretMaladie'  => 'demande_solde_tout_compte.arretMaladie',
                    'demande_solde_tout_compte.absenceInjustifiee' => 'demande_solde_tout_compte.absenceInjustifiee',
                    'demande_solde_tout_compte.congePayes' => 'demande_solde_tout_compte.congePayes',
                    'demande_solde_tout_compte.congeParental' => 'demande_solde_tout_compte.congeParental',
                    'demande_solde_tout_compte.autre' => 'demande_solde_tout_compte.autre',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-controlList labelRadioStyle'],
                  'label' => 'demande_solde_tout_compte.typeAbsence',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('dateDebutAbsence', DateType::class, array(
                  'widget' => 'choice',
                  'format' => 'dd/MM/y',
                  'years' => range(date('Y') - 5, date('Y') + 10),
                  'attr' => ['class' => ''],
                  'label' => ''
                ))
                ->add('dateFinAbsence', DateType::class, array(
                  'widget' => 'choice',
                  'format' => 'dd/MM/y',
                  'years' => range(date('Y') - 5, date('Y') + 10),
                  'attr' => ['class' => ''],
                  'label' => '',
                ))
                ->add('primes', TextType::class, array(
                     'label' => 'demande_solde_tout_compte.primes',
                     'translation_domain' => 'translator',
                     'attr' => ['class' => 'form-control']
                ))
                ->add('remarques', TextareaType::class, array(
                     'label' => 'demande_solde_tout_compte.remarques',
                     'translation_domain' => 'translator',
                     'attr' => ['class' => 'form-control']
                ))
                ->add('rupture', FileType::class, array(
                  'label' => 'global.choiceFile',
                  'translation_domain' => 'translator',
                    ))
              ->add('Envoyer', SubmitType::class, array(
                  'label' => 'global.valider',
                  'attr' => array('class' =>'btn-black end'),
                  'translation_domain' => 'translator'
              ))
              ->addEventListener(FormEvents::POST_SUBMIT,
                  function(FormEvent $event)
                  {
                    $form = $event->getForm();
                    $data = $event->getForm()->getData();

                    $data->setMatricule($form['matricule']->getData()->getMatricule());

                    if ($data->getRupture() != null ){
                      $fileName = $this->fileUploader->upload($data->getRupture(), $data->getMatricule(),'demande_solde_tout_compte', 'rupture');
                      $data->setRupture($fileName);
                    }
                    $event->setData($data);
                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeSoldeToutCompte::class,
      'idSalon' => null,
      'matricule' => null
		));
	}
}
