<?php
namespace AppBundle\Form;

use AppBundle\Entity\DemandeComplexe;
use AppBundle\Entity\DemandeEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Doctrine\ORM\EntityRepository;

class DemandeComplexeType extends AbstractType
{
  private $tokenStorage;

  public function __construct(TokenStorageInterface $tokenStorage)
  {
     $this->tokenStorage = $tokenStorage;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $demande = $options["demande"];

    $builder
        ->setMethod("POST");

    // Vérifie le role et adapte le formulaire
    // Ajout de "rejeter" et "message" pour B.O

    $user = $this->tokenStorage->getToken()->getUser();
    $roles = $this->tokenStorage->getToken()->getRoles();
    $rolesTab = array_map(function($role){
      return $role->getRole();
    }, $roles);

    if (in_array('ROLE_PAIE', $rolesTab, true) || in_array('ROLE_JURIDIQUE', $rolesTab, true))
    {
      if ($demande->getStatut() == DemandeEntity::statut_EN_COURS)
      {
        $builder
          ->add('message', TextareaType::class, array(
            'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
            'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
            'label' => 'Motif',
          ))
          ->add('docService', FileType::class, ['label' => 'Ajouter un document'])
          ->add('accept', SubmitType::class, array( 'attr' => ['class'=>'btn-black end accept']))
          ->add('reject', SubmitType::class, array( 'attr' => ['class'=>'btn-black end reject']));
      }

      if ($demande->getStatut() == DemandeEntity::statut_AVALIDE)
      {
        $builder
            ->add('message', TextareaType::class, array(
              'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
              'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
              'label' => 'Motif',
            ))
            ->add('accept', SubmitType::class, array('attr' => ['class' => 'btn-black end accept'], 'label' => 'Validé'))
            ->add('reject', SubmitType::class, array('attr' => ['class' => 'btn-black end reject']))
            ;
      }
    }
    else
    {
      // Si l'utilisateur est un manager ou un coordo
      if($demande->getStatut() == DemandeEntity::statut_ASIGNE)
      {
        $builder->add('docSalon', FileType::class, ['label' => 'Ajouter un document'])
                ->add('accept', SubmitType::class, array( 'attr' => ['class'=>'btn-black end accept'],'label'=>'Renvoyer'));
      }

    }

    // Visible uniquement pour le B.O
    // if($demande->getStatut() == DemandeEntity::statut_EN_COURS)
    // {
    //    $builder->add('docService', FileType::class)
    //       ->add('docService', FileType::class, ['label' => 'Doc service']);
    // }

    // // Visible uniquement pour les salons
    // if($demande->getStatut() == DemandeEntity::statut_ASIGNE)
    // {
    //   $builder->add('docSalon', FileType::class)
    //       ->add('docSalon', FileType::class, ['label' => 'Ajouter un document']);
    // }

    // if($demande->getStatut() == DemandeEntity::statut_AVALIDE)
    // {
    //   $builder->add('docSalon', FileType::class)
    //       ->add('accept', SubmitType::class, ['label' => 'Renvoyer']);
    // }
    //
    // // Lorsque la demande est finalisé
    // // Les document sont accessibles depuis la demande
    // if($demande->getStatut() == DemandeEntity::statut_TRAITE)
    // {
    //   $builder->add('accept', SubmitType::class)
    //           ->add('docSalon', TextType::class, ['attr' => ['class' => 'getDocument', 'readonly' => true], 'label' => 'Doc salon'])
    //           ->add('docService', TextType::class, ['attr' => ['class' => 'getDocument', 'readonly' => true], 'label' => 'Doc Service']);
    // }
  }


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeComplexe::class,
      'demande'    => null
		));
	}
}
