<?php

namespace AppBundle\Form;

use AppBundle\Entity\AutreDemande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;


use Doctrine\ORM\EntityRepository;

class AutreDemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $idSalon = $options["idSalon"];
      $idPersonnel = $options["idPersonnel"];

      if ($idSalon == null){
        $builder
         ->add('idPersonnel', EntityType::class, array(
              // query choices from this entity
              'class' => 'ApiBundle:Personnel',
              // use the User.username property as the visible option string
              'choice_label' => function ($personnel) {
                    return $personnel->getNom() ." ". $personnel->getPrenom();
                  },
              'query_builder' => function (EntityRepository $er) use ($idPersonnel) {
                  return $er->createQueryBuilder('p');
                },
              'label' => 'autredemande.nom',
              'translation_domain' => 'autre_demande'
            ))
          ->add('service', ChoiceType::class, array(
                   'choices' => array('Service Paie' => 'paie', 'Service Juridique' => 'Juridique',
                   'Service Informatique' => 'Informatique'),
                   'expanded' => false,
                   'multiple' => false,
                   'mapped' => false,
               ))
          ->add('objet', TextType::class, array(
              'label' => 'autredemande.objet',
              'translation_domain' => 'autre_demande',
            ))
            ->add('pieceJointes', FileType::class, array(
                'required'  => false))

          ->add('commentaire', TextareaType::class, array(
                        'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
                        'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
                        'label' => 'autredemande.commentaire',
                        'translation_domain' => 'autre_demande',
            ))
                 ->add('Envoyer', SubmitType::class, array(
                      'label' => 'autredemande.envoyer',
                      'attr' => array('class' =>'btn-black end'),
                      'translation_domain' => 'autre_demande'
                    ))
              ;

      } else {
    //    $builder
    //             ->add('montant', IntegerType::class, array(
    //                  'label' => 'autredemande.montant',
    //                  'translation_domain' => 'autre_demande',
    //                  'attr' => array('min' => '0')
    //             ))
    //           ->add('idPersonnel', EntityType::class, array(
    //               // query choices from this entity
    //               'class' => 'ApiBundle:Personnel',
    //               // use the User.username property as the visible option string
       //
    //               'choice_label' => function ($personnel) {
    //                     return $personnel->getNom() ." ". $personnel->getPrenom();
    //                   },
       //
    //               'query_builder' => function (EntityRepository $er) use ($idSalon) {
    //                   return $er->createQueryBuilder('p')
    //                         ->join('p.salon', 'm')
    //                         ->where('m.id = :idSalon')
    //                         ->setParameter('idSalon', $idSalon);
    //                 },
    //               'label' => 'autredemande.nom',
    //               'translation_domain' => 'autre_demande'
    //             ))
    //           ->add('Envoyer', SubmitType::class, array(
    //               'label' => 'autredemande.envoyer',
    //               'attr' => array('class' =>'btn-black end'),
    //               'translation_domain' => 'autre_demande'
    //             ))
    //       ;
      }



    }

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
	  'data_class' => AutreDemande::class,
      'idSalon' => null,
      'idPersonnel' => null
		));
	}
}
