<?php

namespace AppBundle\Form;

use AppBundle\Entity\RibSalarie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RibSalarieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
//        Récupère info sur User actuel
        //$user = $this->getUser();
        //$userId= $user->getId();
        
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('montant');
    }


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => RibSalarie::class,
		));
	}
}