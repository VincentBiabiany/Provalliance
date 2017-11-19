<?php
namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use ApiBundle\Entity\Salon;
use ApiBundle\Entity\Personnel;
use AppBundle\Entity\Account;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;

class CreateAccountController extends Controller
{
   /**
    * @Route("/admin/create_type", name="createType")
    */
   public function createTypeAction(Request $request)
   {
    return $this->render('admin/createType.html.twig');
   }

   /**
    * @Route("/admin/create", name="createAccountManager")
    */
   public function createAccountAction(Request $request)
   {
    return $this->render('admin/createAccountManager.html.twig',['errors'=>null]);
   }

   /**
    * @Route("/admin/createS1", name="createAccountS1")
    */
   public function createAccountStep1Action(Request $request)
   {
     $form = $this->createFormBuilder()
                   ->add('appelation', EntityType::class, array(
                      'class' => 'ApiBundle:Salon',
                      'choice_label' => 'appelation',
                      'query_builder' => function(EntityRepository $er) {
                          return $er->findSalonForAdmin();
                       },
                      'label' => 'admin.manager.salon',
                      'placeholder' => 'Choisir un salon',
                      'multiple' => false,
                      'translation_domain' => 'translator'
                   ))
                   ->getForm();

          return $this->render('admin/createAccountStep1.html.twig',['form'=>$form->createView()]);

   }

   /**
    * @Route("/admin/createS2", name="createAccountS2")
    */
   public function createAccountStep2Action(Request $request)
   {
     $personnel = new Personnel();
     $idSalon = $request->get('idsalon');
     //On sauvegarde le salon en cas de retour en arrière
     $request->getSession()->set("idSalonAdmin", $idSalon);

     //Retourne la liste des personnels par salon
     $entitym = $this->getDoctrine()->getManager();
     $accountRepo = $entitym->getRepository('AppBundle:Account');

     $entity = $this->getDoctrine()->getManager('referentiel');
     $personnelRepo = $entity->getRepository('ApiBundle:Personnel');
     $listePerso = $personnelRepo->getPerso($idSalon);

     //Filtre des conmptes déjà crées
     foreach ($listePerso as $key => $value) {
       // dump($listePerso);
       // $matricule =  $listePerso[$key]->getPersonnelMatricule()->getMatricule();
       if ($accountRepo->ifInAccount($value)) {
         unset($listePerso[$key]);
       }
     }

     if($listePerso == null ){
       $listePerso['Aucun utilisateur disponible']= null;
     }
     $formS2 = $this->createFormBuilder()
     ->add('nom', ChoiceType::class, array(
       'choices' => $listePerso,
       'label' => 'admin.manager.collab',
       'translation_domain' => 'translator'
     ))
     ->getForm();
     return $this->render('admin/createAccountStep2.html.twig',['formS2'=>$formS2->createView()]);
   }

   /**
    * @Route("/admin/createS3", name="createAccountS3")
    */
  public function createAccountStep3Action(Request $request)
  {
     $formFactory = $this->container->get('fos_user.registration.form.factory');
     $matricule = $request->get('matricule');
     $formS3 = $formFactory->createForm( array('action' => $this->generateUrl('createAccountS3')));

     $formS3 ->add('matricule', HiddenType::class, array(
                     'data' => $matricule ));
     $formS3 ->add('enabled', ChoiceType::class, array(
             'choices'  => array('Activer' => 1,'Désactiver' => 0),
             'expanded' => true,
             'multiple' => false,
             'attr' => array ('class' =>  'form-control'),
             'label' => 'admin.manager.etat',
             'translation_domain' => 'translator'
                     ));
     $formS3 ->add('roles', ChoiceType::class, array(
              'choices' => array('Manager' => 'ROLE_MANAGER', 'Coordinateur' => 'ROLE_COORD'),
              'expanded' => false,
              'multiple' => false,
              'mapped' => false,
              'attr' => array ('class' =>  'form-control'),
              'label' => 'admin.manager.role',
              'translation_domain' => 'translator'
          ));
     $formS3 ->add('email', EmailType::class, array(
              'required'  => false,
                 'attr' => array ('class' =>  'form-control'),
                 'label' => 'admin.manager.email',
                 'translation_domain' => 'translator'));
     $formS3-> add('Valider', SubmitType::class, array(
               'label' => 'global.valider',
               'translation_domain' => 'translator',
               'attr' => array(
                     'class' => 'btn-black end'
                      ))
           );

           if ($request->isMethod('POST')) {
               $formS3->handleRequest($request);

               if ($formS3->isSubmitted() ) {
                  //On met a jour le champ 'compte' de la table Account
                        $idP= $formS3["matricule"]->getData();
                        $em= $this->getDoctrine()->getManager();
                        $personnel = $em->getRepository('AppBundle:Account')->findOneBy(array('matricule' => $idP));
                        $em = $this->getDoctrine()->getManager();

                        $account = new Account();
                        $account->setmatricule($idP);
                        $em->persist($account);

                        $em->flush();

                      //On enregistre les infos principales du User
                      $em = $this->getDoctrine()->getManager();
                      $user = $formS3->getData();
                      $em->persist($user);
                      $em->flush();

                      //On assigne un role à ce même User
                      $idNewUser = $user->getId();
                      $newUser = $this->getDoctrine()
                                        ->getManager()
                                        ->getRepository('AppBundle:User')
                                        ->findOneBy(array("id" => $idNewUser));

                      $newUser->addRole("ROLE_MANAGER");
                      $newUser->setLastLogin(new \DateTime());
                      $newUser->setCreation(new \DateTime());

                      $em->persist($newUser);
                      $em->flush();

                  return $this->render('admin/home.html.twig',
                          ['flash'=>'Le compte Manager a correctement été crée !']);

          }
           return $this->render('admin/createAccountStep3.html.twig',
                    ['formS3'=>$formS3->createView(),'errors' => null]);
     }
  }

}
