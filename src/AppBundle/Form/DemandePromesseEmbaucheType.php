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
use Symfony\Component\HttpFoundation\Session\Session;

class DemandePromesseEmbaucheType extends AbstractType
{
    private $fileUploader;
    private $session;

    public function __construct(FileUploader $fileUploader,Session $session)
    {
    $this->fileUploader = $fileUploader;
    $this->session = $session;

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
                  'label' => '___demande_promesse_embauche.collaborateur',
                  'translation_domain' => 'translator'
                ))
                ->add('contrat', ChoiceType::class, array(
                  'choices'  => array(
                    '___demande_promesse_embauche.cdi'  => '___demande_promesse_embauche.cdi',
                    '___demande_promesse_embauche.cdd' => '___demande_promesse_embauche.cdd',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('poste', ChoiceType::class, array(
                  'choices' => array(
                    '___demande_promesse_embauche.coiffeur' => '___demande_promesse_embauche.coiffeur',
                    '___demande_promesse_embauche.technicien' => '___demande_promesse_embauche.technicien',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'expanded' => true,
                  'multiple' => false,
                  'attr' => ['class' => 'form-control'],
                ))
                ->add('niveau', ChoiceType::class, array(
                  'choices' => array(
                    'I' => 'I',
                    'II' => 'II',
                    'III'=> 'III',
                  ),
                  'label' => '___demande_promesse_embauche.niveau',
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'attr' => ['class' => 'form-control']
                ))
                ->add('echelon', ChoiceType::class, array(
                  'choices' => array(
                    '1' => '1',
                    '2' => '2',
                    '3'=> '3'),
                    'label' => '___demande_promesse_embauche.echelon',
                    'translation_domain' => 'translator',
                    'attr' => ['class' => 'form-control']

                  ))
                ->add('salaire', TextType::class, array(
                     'label' => '___demande_promesse_embauche.salaire',
                     'translation_domain' => 'translator',
                     'attr' => array('min' => '0')
                ))
                ->add('temps', NumberType::class, array(
                     'label' => '___demande_promesse_embauche.temps',
                     'translation_domain' => 'translator',
                ))
                ->add('dateEmbauche', DateType::class, array(
                  'widget' => 'choice',
                  'format' => 'dd/MM/y',
                  'years' => range(date('Y') - 5, date('Y') + 10),
                  'attr' => ['class' => ''],
                  'label' => '___demande_promesse_embauche.dateEmbauche',
                  'translation_domain' => 'translator',
                  'data' => new \DateTime()
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
