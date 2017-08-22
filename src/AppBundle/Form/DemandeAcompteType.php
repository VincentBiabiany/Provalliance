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

class DemandeAcompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        //Récupère info sur User actuel
        //$user = $this->getUser();
        //$userId= $user->getId();

        $builder
            ->add('montant')
            ->add('personnel', EntityType::class, array(
              // query choices from this entity
              'class' => 'ApiBundle:Personnel',
              // use the User.username property as the visible option string
              'choice_label' => 'nom'
              )
            )
            ->add('Envoyer', SubmitType::class)
        ;
    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeAcompte::class,
		));
	}
}
