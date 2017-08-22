<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeAcompte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class DemandeAcompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant', NumberType::class, array(
                'label' => 'demandeacompte.montant',
                'translation_domain' => 'demandeacompte'
              ))
            ->add('idPersonnel', EntityType::class, array(
                // query choices from this entity
                'class' => 'ApiBundle:Personnel',
                // use the User.username property as the visible option string
                'choice_label' => 'nom',
                'label' => 'demandeacompte.nom',
                'translation_domain' => 'demandeacompte'
              ))
            ->add('Envoyer', SubmitType::class, array(
                'label' => 'demandeacompte.envoyer',
                'translation_domain' => 'demandeacompte'
              ))
        ;
    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeAcompte::class,
		));
	}
}
