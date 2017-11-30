<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbsenceType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('typeAbsence', ChoiceType::class, array(
                  'choices'  => array(
                    '___demande_solde_tout_compte.arretMaladie'  => '___demande_solde_tout_compte.arretMaladie',
                    '___demande_solde_tout_compte.absenceInjustifiee' => '___demande_solde_tout_compte.absenceInjustifiee',
                    '___demande_solde_tout_compte.congePayes' => '___demande_solde_tout_compte.congePayes',
                    '___demande_solde_tout_compte.congeParental' => '___demande_solde_tout_compte.congeParental',
                    '___demande_solde_tout_compte.autre' => '___demande_solde_tout_compte.autre',
                  ),
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
                    'attr' => ['class' => 'form-control','required' => 'required'],
                  'label' => '___demande_solde_tout_compte.typeAbsence',
                  'label_attr' => array('class' => 'control-label label'),
                  'expanded' => false,
                  'multiple' => false,
                  'required' => true,
                  'data' => '___demande_solde_tout_compte.arretMaladie'
                ))
            ->add('dateDebut', DateType::class, [
              'attr'       => array('class' => 'styleDate'),
              'widget' => 'choice',
              'format' => 'dd/MM/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'label' => '___demande_absences.date',

              'label_attr' => array('class' => 'control-label label'),
              'translation_domain' => 'translator',
              'attr' => ['class' => ' styleDate ','required' => 'required'],
              'data' => new \DateTime()
            ])
            ->add('dateFin', DateType::class, [
                      'attr'       => array('class' => 'styleDate'),
                      'widget' => 'choice',
                      'format' => 'dd/MM/y',
                      'years' => range(date('Y') - 5, date('Y') + 10),
                      'label' => '___demande_absences.date',
                      'label_attr' => array('class' => 'control-label label'),
                      'translation_domain' => 'translator',
                      'attr' => ['class' => ' styleDate ','required' => 'required'],
                      'data' => new \DateTime()
                    ]);
  }

  public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => null,
      'idSalon' => null,
      'matricule' => null
		));
	}

}
