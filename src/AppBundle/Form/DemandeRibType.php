<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeRib;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;

class DemandeRibType extends AbstractType
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
                  'label' => 'demanderib.collaborateur',
                  'translation_domain' => 'demande_rib'
                ))
                ->add('rib', FileType::class, array(
                  'label' => 'autredemande.rib',
                  'translation_domain' => 'demande_rib',
                    ))
              ->add('Envoyer', SubmitType::class, array(
                  'label' => 'demanderib.envoyer',
                  'attr' => array('class' =>'btn-black end'),
                  'translation_domain' => 'demande_rib'
              ))
              ->addEventListener(FormEvents::POST_SUBMIT,
                  function(FormEvent $event)
                  {
                    $form = $event->getForm();
                    $data = $event->getForm()->getData();

                    $data->setMatricule($form['matricule']->getData()->getMatricule());
                    $event->setData($data);
                    
                    if ($data->getRib() != null ){
                    $fileName = $this->fileUploader->upload($data->getRib());
                    $data->setRib($fileName);

                    }
                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeRib::class,
          'idSalon' => null,
          'matricule' => null
		));
	}
}