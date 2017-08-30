<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeEmbauche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DemandeEmbaucheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')

            ->add('addresse2')
            ->add('codePostal', NumberType::class)
            ->add('ville')
            ->add('telephone')
            ->add('email', EmailType::class)
            ->add('numSecu')
            ->add('dateNaissance')
            ->add('villeNaissance')
            ->add('nationalite', ChoiceType::class, array(
                'choices'  => array(
                    'Francaise' => 'francaise',
                    'Etrangère' => 'etrangère',
              )
            ))
            ->add('nbEnfant')
            ->add('situationFamille', ChoiceType::class, array(
                'choices'  => array(
                    'Marié' => 'marié',
                    'Pacsé' => 'pacsé',
                    'Concubinage' => 'concubinage',
                    'Célibataire' => 'célibataire',
              )
            ))
            ;

      $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
          $form = $event->getForm();
          $data = $event->getForm()->getData();
          if($data->getNationalite() != "etrangère")
            $form->add('addresse1', TextType::class, array(
              'attr' => array(
                    'class' => $data->getNationalite(),
                ),));
      });
    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeEmbauche::class,
		));
	}
}
