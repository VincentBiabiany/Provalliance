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
            'label' => '___demande_rupture_cdd.collaborateur',
            'translation_domain' => 'translator'
          ))
        ->add('finCddLe', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('retourCollabLe', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('finCddLe2', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('departCollabLe', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('embSalonLe', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('departPrevuLe', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('departPrevuLe2', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 5, date('Y') + 10),
          'attr' => ['class' => ''],
          'label' => '',
          'data' => new \DateTime()

        ))
        ->add('raison', ChoiceType::class, array(
          'choices' => array(
            '___demande_rupture_cdd.retour'   => '___demande_rupture_cdd.retour',
            '___demande_rupture_cdd.depart'   => '___demande_rupture_cdd.depart',
            '___demande_rupture_cdd.rupture'  => '___demande_rupture_cdd.rupture',
          ),
          'choice_translation_domain' => 'translator',
          'translation_domain' => 'translator',
          'expanded' => true,
          'multiple' => false,
        ))
        ->add('ruptureAnticipe', ChoiceType::class, array(
          'choices' => array(
            '___demande_rupture_cdd.cdi'     => '___demande_rupture_cdd.cdi',
            '___demande_rupture_cdd.cdi2'    => '___demande_rupture_cdd.cdi2',
            '___demande_rupture_cdd.demande' => '___demande_rupture_cdd.demande',
            '___demande_rupture_cdd.accord'  => '___demande_rupture_cdd.accord',
            '___demande_rupture_cdd.accord2' => '___demande_rupture_cdd.accord2',
          ),
          'choice_translation_domain' => 'translator',
          'translation_domain' => 'translator',
          'expanded' => true,
          'multiple' => false,
        ))
        ->add('lettre', FileType::class, array(
          'label' => '___demande_rupture_cdd.rib',
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

              if ($data->getRaison() == '___demande_rupture_cdd.retour') {

                $save = $data->getFinCddLe();
                $save2 = $data->getRetourCollabLe();

                self::setAllDateNull($data);

                $data->setFinCddLe($save);
                $data->setRetourCollabLe($save2);

              } else if ($data->getRaison() == '___demande_rupture_cdd.depart') {

                $save = $data->getFinCddLe();
                $save2 = $data->getDepartCollabLe();

                self::setAllDateNull($data);

                $data->setFinCddLe2($save);
                $data->setDepartCollabLe($save2);
              }


              if ($data->getRaison() == '___demande_rupture_cdd.rupture') {

                $rupt = $data->getRuptureAnticipe();

                if ($rupt == '___demande_rupture_cdd.cdi') {
                  $data->setNomCollab(null);

                  $save = $data->getEmbSalonLe();
                  self::setAllDateNull($data);
                  $data->setEmbSalonLe($save);

                } else if ($rupt == '___demande_rupture_cdd.cd2') {

                  $save = $data->getDepartPrevuLe();
                  self::setAllDateNull($data);
                  $data->setDepartPrevuLe($save);

                } else if ($rupt == '___demande_rupture_cdd.lettre') {
                  $fileName = $this->fileUploader->upload($data->getLettre(), $data->getMatricule(),'demande_rib', 'rib');
                  $data->setLettre($fileName);

                  $save = $data->getDepartPrevuLe2();
                  self::setAllDateNull($data);
                  $data->setDepartPrevuLe2($save);

                } else {
                  self::setAllDateNull($data);
                }
              }
              $event->setData($data);
            }
        );
  }

  public function setAllDateNull($data)
  {
    $data->setFinCddLe2(null);
    $data->setDepartCollabLe(null);
    $data->setFinCddLe(null);
    $data->setRetourCollabLe(null);
    $data->setDepartPrevuLe(null);
    $data->setDepartPrevuLe2(null);
    $data->setEmbSalonLe(null);

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
