<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeAttestationSalaire;
use AppBundle\Form\DemandeAttestationSalaireType;
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


class DemandeAttestationSalaireType extends AbstractType
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
                  'label' => 'demande_attestation_salaire.collaborateur',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-control','required' => 'required']
                ))
                ->add('etat', ChoiceType::class, array(
                  'choices'  => array(
                    'demande_attestation_salaire.reprise'  => 'demande_attestation_salaire.reprise',
                    'demande_attestation_salaire.nonReprise' => 'demande_attestation_salaire.nonReprise',
                    'demande_attestation_salaire.prolongation' => 'demande_attestation_salaire.prolongation',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-controlList labelRadioStyle'],
                  'label' => 'demande_attestation_salaire.etat',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('motif', ChoiceType::class, array(
                  'choices'  => array(
                    'demande_attestation_salaire.maladie'  => 'demande_attestation_salaire.maladie',
                    'demande_attestation_salaire.maternite' => 'demande_attestation_salaire.maternite',
                    'demande_attestation_salaire.paternite' => 'demande_attestation_salaire.paternite',
                    'demande_attestation_salaire.miTemps' => 'demande_attestation_salaire.miTemps',
                    'demande_attestation_salaire.accidentTravail' => 'demande_attestation_salaire.accidentTravail',
                    'demande_attestation_salaire.maladiePro' => 'demande_attestation_salaire.maladiePro',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-controlList labelRadioStyle'],
                  'label' => 'demande_attestation_salaire.motif',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('dateReprise', DateType::class, array(
                'widget' => 'choice',
                'format' => 'dd/MM/y',
                'years' => range(date('Y') - 100, date('Y') - 20),
                'attr' => ['class' => 'form-control styleDate','name'=>'date'],
                'data' => new \DateTime()

                ))
                ->add('dateDernierJour', DateType::class, array(
                'widget' => 'choice',
                'format' => 'dd/MM/y',
                'years' => range(date('Y') - 100, date('Y') - 20),
                'attr' => ['class' => 'form-control styleDate','name'=>'date'],
                'data' => new \DateTime()

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

                    // if ($data->getRupture() != null ){
                    //   $fileName = $this->fileUploader->upload($data->getRupture(), $data->getMatricule(),'demande_attestation_salaire', 'rupture');
                    //   $data->setRupture($fileName);
                    // }
                    $event->setData($data);
                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeAttestationSalaire::class,
      'idSalon' => null,
      'matricule' => null
		));
	}
}
