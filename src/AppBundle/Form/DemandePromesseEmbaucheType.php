<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandePromesseEmbauche;
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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;

class DemandePromesseEmbaucheType extends AbstractType
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
                  'label' => 'demande_promesse_embauche.collab',
                  'translation_domain' => 'translator'
                ))
                ->add('contrat', ChoiceType::class, array(
                  'choices'  => array(
                    'demande_promesse_embauche.cdi'  => 'demande_promesse_embauche.cdi',
                    'demande_promesse_embauche.cdd' => 'demande_promesse_embauche.cdd',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('poste', TextType::class, array(
                      'label' => 'demande_promesse_embauche.poste',
                      'translation_domain' => 'translator',
                    ))
                ->add('niveau', TextType::class, array(
                      'label' => 'demande_promesse_embauche.niveau',
                      'translation_domain' => 'translator',
                    ))
                ->add('echelon', TextType::class, array(
                      'label' => 'demande_promesse_embauche.echelon',
                      'translation_domain' => 'translator',
                    ))
                ->add('salaire', TextType::class, array(
                     'label' => 'demande_promesse_embauche.salaire',
                     'translation_domain' => 'translator',
                     'attr' => array('min' => '0')
                ))
                ->add('temps', TextType::class, array(
                     'label' => 'demande_promesse_embauche.temps',
                     'translation_domain' => 'translator',
                ))
                ->add('dateEmbauche', DateType::class, array(
                  'widget' => 'choice',
                  'format' => 'dd/MM/y',
                  'years' => range(date('Y') - 100, date('Y') - 20),
                  'attr' => ['class' => ''],
                  'label' => 'demande_promesse_embauche.dateEmbauche',
                  'translation_domain' => 'translator'))
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
                    $event->setData($data);

                    // if ($data->getDem() != null ){
                    // $fileName = $this->fileUploader->upload($data->getDem(),0,'demission', 'dem');
                    // $data->setDem($fileName);
                    //
                    // }
                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
		   	'data_class' => DemandePromesseEmbauche::class,
          'idSalon' => null,
          'matricule' => null
		));
	}
}
