<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeEssaiProfessionnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;

class DemandeEssaiProfessionnelType extends AbstractType
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
                ->add('nom', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('prenom', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('adresse', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('codePostal', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('ville', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('dateNaissance', DateType::class, array(
                          'widget' => 'choice',
                          'format' => 'dd/MM/y',
                          'years' => range(date('Y') - 100, date('Y') - 20),
                          'attr' => ['class' => 'form-control styleDate','name'=>'date']
                ))
                ->add('nationalite', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('lieuNaissance', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('departement', null, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('numSecu', TextType::class, array(
                          'attr' => ['class' => 'form-control',
                          'placeholder' => '_  _ _  _ _  _ _  _ _ _  _ _ _  _ _']
                ))
                ->add('dateEssai', DateType::class, array(
                          'widget' => 'choice',
                          'format' => 'dd/MM/y',
                          'years' => range(date('Y') - 5, date('Y') + 2),
                          'data' => new \DateTime(),
                          'attr' => ['class' => 'form-control styleDate','name'=>'date']
                ))
                ->add('niveau', ChoiceType::class, array(
                          'choices' => array(
                            'I' => 'I',
                            'II' => 'II',
                            'III'=> 'III',
                          ),
                          'attr' => ['class' => 'form-control']
                        ))
                ->add('diplomes', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('qualification', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('nbHeures', null, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('priseReference', ChoiceType::class, array(
                          'choices'  => array(
                            'demande_essai_pro.oui'  => 'demande_essai_pro.oui',
                            'demande_essai_pro.non' => 'demande_essai_pro.non'),
                          'attr' => ['class' => 'form-control labelRadioStyle'],
                          'choice_translation_domain' => 'translator',
                          'translation_domain' => 'translator',
                          'expanded' => true,
                          'multiple' => false,
                          'required' => true,
                ))
                ->add('telephone', TextType::class, array(
                          'attr' => ['class' => 'form-control']
                ))
                ->add('carteId', FileType::class)
                ->add('rib', FileType::class)
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

                    // $data->setMatricule($form['matricule']->getData()->getMatricule());
                    // $matricule = $form['matricule']->getData()->getMatricule();
                    // $event->setData($data);

                    if ($data->getRib() != null && $data->getCarteId() != null){
                    $rib = $this->fileUploader->upload($data->getRib(),'0','essai_pro', 'rib');
                    $carteId = $this->fileUploader->upload($data->getCarteId(),'0','essai_pro', 'carteId');
                    $data->setRib($rib);
                    $data->setCarteId($carteId);

                    }
                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
		   	'data_class' => DemandeEssaiProfessionnel::class,
          'idSalon' => null,
          'matricule' => null
		));
	}
}
