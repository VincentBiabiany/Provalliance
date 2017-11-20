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

    if (in_array('ROLE_PAIE', $rolesTab, true) || in_array('ROLE_JURIDIQUE', $rolesTab, true)) {

      if ($demande->getStatut() == DemandeEntity::statut_EN_COURS) {
        $builder->add('message', TextareaType::class, array(
                  'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
                  'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
                  'label' => 'Motif',
                ))
                ->add('docService', FileType::class, ['label' => 'Ajouter un document'])
                ->add('reject', SubmitType::class, array( 'attr' => ['class'=>'btn-black end reject']))
                ->add('accept', SubmitType::class, array( 'attr' => ['class'=>'btn-black end accept']));

      }

      if ($demande->getStatut() == DemandeEntity::statut_AVALIDE) {
        $builder
            ->add('message', TextareaType::class, array(
              'attr' => ['class' => 'form-control col-sm-9 col-xs-12'],
              'label_attr' => ['class' => 'control-label label col-sm-3 col-xs-12'],
              'label' => 'Motif',
            ))
            ->add('reject', SubmitType::class, array('attr' => ['class' => 'btn-black end reject']))
            ->add('accept', SubmitType::class, array('attr' => ['class' => 'btn-black end accept'], 'label' => 'Validé'))
            ;
      }

    } else {
      // Si l'utilisateur est un manager ou un coordo
      if ($demande->getStatut() == DemandeEntity::statut_ASIGNE) {
        $builder->add('docSalon', FileType::class, ['label' => 'Ajouter un document'])
                ->add('accept', SubmitType::class, array( 'attr' => ['class'=>'btn-black end accept'],'label'=>'Renvoyer'));
      }

    }
  }


	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => DemandeComplexe::class,
      'demande'    => null
		));
	}
}
