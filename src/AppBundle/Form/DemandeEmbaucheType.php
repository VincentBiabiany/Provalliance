<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeEmbauche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeEmbaucheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('addresse1')
            ->add('addresse2')
            ->add('codePostal')
            ->add('ville')
            ->add('telephone')
            ->add('email')
            ->add('numSecu')
            ->add('dateNaissance')
            ->add('villeNaissance')
            ->add('nationalite')
            ->add('nbEnfant')
            ;
    }


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeEmbauche::class,
		));
	}
}