<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeDemission;
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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Service\FileUploader;

class DemandeDemissionType extends AbstractType
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
                  'label' => 'demande_demission.collab',
                  'translation_domain' => 'translator'
                ))
                ->add('moyen', ChoiceType::class, array(
                  'choices'  => array(
                    'demande_demission.desactiver'  => 'demande_demission.desactiver',
                    'demande_demission.payer' => 'demande_demission.payer',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                  'expanded' => true,
                  'multiple' => false,
                  'required' => true,
                ))
                ->add('date', DateType::class, array(
                  'widget' => 'choice',
                  'format' => 'd/M/y',
                  'years' => range(date('Y') - 100, date('Y') - 20),
                  'attr' => ['class' => '']))
                ->add('dem', FileType::class, array(
                  'label' => 'demande_demission.dem',
                  'translation_domain' => 'translator',
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

                    if ($data->getDem() != null ){
                    $fileName = $this->fileUploader->upload($data->getDem(),0,'demission', 'dem');
                    $data->setDem($fileName);

                    }
                  });

    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
		   	'data_class' => DemandeDemission::class,
          'idSalon' => null,
          'matricule' => null
		));
	}
}