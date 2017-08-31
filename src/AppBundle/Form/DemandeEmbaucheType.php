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
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class DemandeEmbaucheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      switch ($options['step']) {
        case '1':
        $builder
            ->add('nom', null, array('attr' => ['class' => 'form-control']))
            ->add('prenom', null, array('attr' => ['class' => 'form-control']))
            ->add('addresse1', null, array('attr' => ['class' => 'form-control']))
            ->add('addresse2', null, array('attr' => ['class' => 'form-control']))
            ->add('codePostal', NumberType::class, array('attr' => ['class' => 'form-control']))
            ->add('ville', null, array('attr' => ['class' => 'form-control']))
            ->add('telephone', null, array('attr' => ['class' => 'form-control']))
            ->add('email', EmailType::class, array('attr' => ['class' => 'form-control']))
            ->add('numSecu', null, array('attr' => ['class' => 'form-control']))
            ->add('dateNaissance', DateType::class, array(
                              'widget' => 'single_text',
                              'html5' => false,
                              'attr' => ['class' => 'js-datepicker form-control']))
            ->add('villeNaissance')
            ->add('nationalite', ChoiceType::class, array(
                'choices'  => array(
                    'Francaise' => 'francaise',
                    'Etrangère' => 'etrangère',
              ),
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('nbEnfant', null, array('attr' => ['class' => 'form-control']))
            ->add('situationFamille', ChoiceType::class, array(
                'choices'  => array(
                    'Marié' => 'marié',
                    'Pacsé' => 'pacsé',
                    'Concubinage' => 'concubinage',
                    'Célibataire' => 'célibataire',
              ),
                'attr' => ['class' => 'form-control']
            ))
            ->add('villeNaissance', null, array('attr' => ['class' => 'form-control']))
            ->add('Envoyer', SubmitType::class, array(
                              'label' => 'demandeacompte.envoyer',
                              'attr' => array('class' =>'btn-black end'),
                              'translation_domain' => 'demandeacompte'
                            ))
            ;
          break;
        case '2':
          $builder->add('dateembauche', DateType::class, array(
                            'widget' => 'single_text',
                            'html5' => false,
                            'attr' => ['class' => 'js-datepicker form-control'],))
                  ->add('dejaSalarie', ChoiceType::class,array(
                           'choices' => array('Oui' => true, 'Non' => false),
                           'expanded' => true,
                           'multiple' => false,
                          ))
                  ->add('poste', ChoiceType::class,array(
                           'choices' => array('Coiffeur' => 'coiffeur', 'Technicien' => 'technicien', 'Autre'=> 'autre'),
                           'expanded' => true,
                           'multiple' => false,
                         ))
                  ->add('diplomes', ChoiceType::class,array(
                           'choices' => array('CAP' => 'CAP', 'BEP' => 'BEP', 'Autre'=> 'autre'),
                           'expanded' => true,
                           'multiple' => false,
                         ))
                  ->add('classification', ChoiceType::class,array(
                           'choices' => array('Coiffeur' => 'coiffeur', 'Technicien' => 'technicien', 'Autre'=> 'autre'),
                           'expanded' => true,
                           'multiple' => false,
                         ))
                  ->add('salaireBase', ChoiceType::class,array(
                           'choices' => array('Salaire conventionnel' => 'conventionnel', 'Autre' => 'autre'),
                           'expanded' => true,
                           'multiple' => false,
                         ))
                  ->add('typeContrat', ChoiceType::class,array(
                           'choices' => array('CDI' => 'CDI', 'Contrat d\'apprentissage' => 'Contrat d\'apprentissage', '
Contrat de profes.' => 'Contrat de profes.'),
                           'expanded' => true,
                           'multiple' => false,
                         ))
                         ;
          break;
      }


      // $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
      //     $form = $event->getForm();
      //     $data = $event->getForm()->getData();
      //     if ($data->getNationalite() != "etrangère")
      //       $form->add('addresse1', TextType::class, array(
      //         'attr' => array(
      //               'class' => $data->getNationalite(),
      //           ),));
      // });
    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeEmbauche::class,
      'allow_extra_fields' => true,
      'step' => null
		));
	}
}
