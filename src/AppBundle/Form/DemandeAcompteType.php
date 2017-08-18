<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeAcompte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeAcompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
//        Récupère info sur User actuel
        $user = $this->getUser();
        $userId= $user->getId();
        
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('solde')
            ->add('id_personnel', HiddenType::class, array(
            'data' => '12'))
            ->add('id_demandeur', HiddenType::class, array(
            'data' => 6))
            ;
    }


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeAcompte::class,
		));
	}
}