<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;
use AppBundle\Entity\DemandeRuptureCdd;

class DemandeRuptureCddType extends AbstractType
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
            'label' => 'demande_rib.collaborateur',
            'translation_domain' => 'translator'
          ))
        ->add('dateFin', DateType::class, array(
          'widget' => 'choice',
          'format' => 'd/M/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => ''
        ))
        ->add('dateDepart', DateType::class, array(
          'widget' => 'choice',
          'format' => 'd/M/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
        ))
        ->add('raison', ChoiceType::class, array(
          'choices' => array(
            'rupture_cdd.retour'   => 'rupture_cdd.retour',
            'rupture_cdd.depart'   => 'rupture_cdd.depart',
            'rupture_cdd.rupture'  => 'rupture_cdd.rupture',
          ),
          'choice_translation_domain' => 'translator',
          'translation_domain' => 'translator',
          'expanded' => true,
          'multiple' => false,
        ))
        ->add('ruptureAncticipe', ChoiceType::class, array(
          'choices' => array(
            'rupture_cdd.cdi'     => 'rupture_cdd.cdi',
            'rupture_cdd.cdi2'    => 'rupture_cdd.cdi2',
            'rupture_cdd.demande' => 'rupture_cdd.demande',
            'rupture_cdd.accord'  => 'rupture_cdd.accord',
            'rupture_cdd.accord2' => 'rupture_cdd.accord2',
          ),
          'choice_translation_domain' => 'translator',
          'translation_domain' => 'translator',
          'expanded' => true,
          'multiple' => false,
        ))
        ->add('lettre', FileType::class, array(
          'label' => 'demande_rib.rib',
          'translation_domain' => 'translator',
            ))
        ->add('nomCollab', TextType::class, array(
            ))
        ->add('Envoyer', SubmitType::class, array(
            'label' => 'global.submit',
            'attr' => array('class' =>'btn-black end'),
            'translation_domain' => 'translator'
        ))
        ->addEventListener(FormEvents::POST_SUBMIT,
            function(FormEvent $event)
            {
              $form = $event->getForm();
              $data = $event->getForm()->getData();

              $data->setMatricule($form['matricule']->getData()->getMatricule());

              if ($data->getRaison() == 'rupture_cdd.rupture') {
                $rupt = $data->getRuptureAncticipe();
                if ($rupt == 'rupture_cdd.lettre') {
                  $fileName = $this->fileUploader->upload($data->getLettre(), $data->getMatricule(),'demande_rib', 'rib');
                  $data->setLettre($fileName);
                  $data->setDateDepart(null);
                  $data->setNomCollab(null);
                } else if ($rupt == 'rupture_cdd.lettre' || $rupt == "") {
                  $data->setDateDepart(null);
                  $data->setNomCollab(null);
                } else {
                  $data->setLettre(null);
                  $data->setDateDepart(null);
                  $data->setDateFin(null);
                  $data->setNomCollab(null);
                }
              }
              $event->setData($data);
            }
        );
  }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeRuptureCdd::class,
          'idSalon' => null,
          'matricule' => null
		));
	}
}
