<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;



class RetardsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('date', DateType::class, [
              'attr'       => array('class' => 'styleDate'),
              'widget' => 'choice',
              'format' => 'dd/MM/y',
              'years' => range(date('Y') - 5, date('Y') + 10),
              'label' => '___demande_absences.date',
              'label_attr' => array('class' => 'control-label label'),
              'translation_domain' => 'translator',
              'attr' => ['class' => ' styleDate ','required' => 'required']
            ])
            ->add('minute', NumberType::class, [
              'label' => '___demande_absences.minute',
              'label_attr' => array('class' => 'control-label label'),
              'translation_domain' => 'translator',
              'attr' => ['class' => 'form-control','required' => 'required']
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
