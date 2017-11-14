<?php

namespace AppBundle\Form;

use AppBundle\Entity\AutreDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;


class AutreDemandeType extends AbstractType
{
    private $fileUploader;

    public function __construct(FileUploader $fileUploader)
    {
      $this->fileUploader = $fileUploader;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $idSalon = $options["idSalon"];
      $listePerso = $options["listePerso"];

       $builder
                ->add('matricule', ChoiceType::class, array(
                      'choices' => $listePerso,
                      'label' => 'autre_demande.collab',
                      'translation_domain' => 'translator'
                     ))
                ->add('service', ChoiceType::class, array(
                          'choices' => array('Service Paie' => 'paie', 'Service Juridique' => 'juridique',
                          'Service Informatique' => 'informatique'),
                          'expanded' => false,
                          'multiple' => false
                        ))
                ->add('objet', TextType::class, array(
                      'label' => 'autre_demande.objet',
                      'translation_domain' => 'translator',
                    ))
                ->add('pieceJointes', FileType::class, array(
                  'required'  => false,
                  'label' => 'autre_demande.pieceJointe',
                  'translation_domain' => 'translator',
                    ))
                ->add('commentaire', TextareaType::class, array(
                                  'label' => 'autre_demande.commentaire',
                                  'translation_domain' => 'translator',
                                  'attr' => array('rows' => '5')
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
                    $data->setMatricule($form['matricule']->getData());
                    $event->setData($data);

                    if ($data->getPieceJointes() != null ){
                    $fileName = $this->fileUploader->upload($data->getPieceJointes(),0,'autre_demande', 'pieceJointe');
                    $data->setPieceJointes($fileName);

                    }

                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
		      'data_class' => AutreDemande::class,
              'idSalon' => null,
              'matricule' => null,
              'listePerso' => null
        		));
	}
}
