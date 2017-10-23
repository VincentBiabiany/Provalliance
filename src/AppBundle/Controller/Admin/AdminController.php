<?php
namespace AppBundle\Controller\Admin;
use AppBundle\Entity\User;
use ApiBundle\Entity\Salon;
use ApiBundle\Entity\Personnel;
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

class AdminController extends Controller
{
  /**
    * @Route("/admin", name="adminHome")
    */
   public function indexAction()
   {
        return $this->render('admin/home.html.twig',
        ['flash'=>null]);

   }
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
                     'label' => 'admin_create.salon',
                     'placeholder' => ' Choisir un salon',
                     'multiple' => false,
                     'translation_domain' => 'admin_create'
                  ))
                ->getForm()
           ;
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
            //Retourne la liste des personnels n'ayant pas encore crée de compte
            $entitym = $this->getDoctrine()->getManager();
            $accountRepo = $entitym->getRepository('AppBundle:Account');
            $listeAccount = $accountRepo->getAccountOff($idSalon);

            $entity = $this->getDoctrine()->getManager('referentiel');
            $personnelRepo = $entity->getRepository('ApiBundle:Personnel');
            $listePerso = $personnelRepo->getPerso($listeAccount,$idSalon);

            if($listePerso == null ){
               $listePerso['Aucun utilisateur disponible']= null;
            }
            $formS2 = $this->createFormBuilder()
            ->add('nom', ChoiceType::class, array(
                 'choices' => $listePerso,
                 'label' => 'admin_create.nom',
                 'translation_domain' => 'admin_create'
              ))
            ->getForm()
            ;
          return $this->render('admin/createAccountStep2.html.twig',['formS2'=>$formS2->createView()]);
    }

    /**
     * @Route("/admin/createS3", name="createAccountS3")
     */
   public function createAccountStep3Action(Request $request)
   {
      $formFactory = $this->container->get('fos_user.registration.form.factory');
      $idPersonnel = $request->get('idpersonnel');
      $formS3 = $formFactory->createForm( array('action' => $this->generateUrl('createAccountS3')));

      $formS3 ->add('idPersonnel', HiddenType::class, array(
                      'data' => $idPersonnel ));
      $formS3 ->add('enabled', ChoiceType::class, array(
              'choices'  => array('Activer' => 1,'Désactiver' => 0),
              'expanded' => true,
              'multiple' => false,
              'attr' => array ('class' =>  'form-control'),
              'label' => 'admin_create.etat',
              'translation_domain' => 'admin_create'
                      ));
      $formS3 ->add('roles', ChoiceType::class, array(
               'choices' => array('Manager' => 'ROLE_MANAGER', 'Coordinateur' => 'ROLE_COORD'),
               'expanded' => false,
               'multiple' => false,
               'mapped' => false,
               'attr' => array ('class' =>  'form-control'),
               'label' => 'admin_create.role',
               'translation_domain' => 'admin_create'
           ));
      $formS3 ->add('email', EmailType::class, array(
               'required'  => false,
                  'attr' => array ('class' =>  'form-control'),               'label' => 'admin_create.email',
               'translation_domain' => 'admin_create'));
      $formS3-> add('Valider', SubmitType::class, array(
            'label' => 'global.valider',
            'translation_domain' => 'global',
            'attr' => array(
                  'class' => 'btn-black end'
                   ))
            );

            if ($request->isMethod('POST')) {
                $formS3->handleRequest($request);

                if ($formS3->isSubmitted() ) {
                   //On met a jour le champ 'compte' de la table Account
                        $idP= $formS3["idPersonnel"]->getData();
                        $em= $this->getDoctrine()->getManager();
                        $personnel = $em->getRepository('AppBundle:Account')->findOneBy(array('idPersonnel' => $idP));

                        $personnel->setEtat(1);
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
       /**
         * @Route("/admin/create_service", name="createAccountService")
         */
      public function createAccountServiceAction(Request $request)
      {
         $formFactory = $this->container->get('fos_user.registration.form.factory');
         $form = $formFactory->createForm( array('action' => $this->generateUrl('createAccountService')));
         $form ->add('idPersonnel', HiddenType::class, array(
                         'data' => 0));
         $form ->add('enabled', ChoiceType::class, array(
                  'choices'  => array('Activer' => 1,'Desactiver' => 0),
                  'expanded' => true,
                  'multiple' => false,
                  'label' => 'admin_create.etat',
                  'translation_domain' => 'admin_create'));
         $form ->add('roles', ChoiceType::class, array(
                  'choices' => array('Service Paie' => 'ROLE_PAIE', 'Service Juridique / RH ' => 'ROLE_Juridique'),
                  'expanded' => false,
                  'multiple' => false,
                  'mapped' => false,
                  'label' => 'admin_create.role',
                  'translation_domain' => 'admin_create'
              ) );
         $form ->add('email', EmailType::class, array(
                  'required'  => false,
                  'label' => 'admin_create.email',
                  'translation_domain' => 'admin_create'));
         $form-> add('Valider', SubmitType::class, array(
               'label' => 'global.valider',
               'translation_domain' => 'global',
               'attr' => array(
                     'class' => 'btn-black end'))
               );

               if ($request->isMethod('POST')) {
                   $form->handleRequest($request);

                   if ($form->isSubmitted() && $form->isValid()) {

                          //On enregistre les infos principales du User
                          $em = $this->getDoctrine()->getManager();
                          $user = $form->getData();
                          $em->persist($user);
                          $em->flush();

                          //On assigne un role à ce même User
                          $idNewUser = $user->getId();
                          $newUser = $this->getDoctrine()
                                            ->getManager()
                                            ->getRepository('AppBundle:User')
                                            ->findOneBy(array("id" => $idNewUser));

                          $roles= $form["roles"]->getData();
                          $newUser->addRole($roles);
                          $newUser->setLastLogin(new \DateTime());
                          $newUser->setCreation(new \DateTime());

                          $em->persist($newUser);
                          $em->flush();
                     //  $this->addFlash("success", "Le compte Service a correctement été crée !");
                      return $this->render('admin/home.html.twig',['form'=>$form->createView(),
                      'flash'=>'Le compte Service a correctement été crée']);
                   }else{
                      $validator = $this->get('validator');
                      $errors = $validator->validate($form);
                     if (count($errors) > 0) {
                             $errorsString = (string) $errors;

                      return $this->render('admin/createAccountService.html.twig',['form'=>$form->createView(),'flash'=>$errorsString]);


                   }
               }
            }
               return $this->render('admin/createAccountService.html.twig',['form'=>$form->createView(),'flash'=>null]);
      }

   /**
    * @Route("/admin/uniqueUsername", name="uniqueUsername")
    */
   public function uniqueUsername(Request $request){

      $uniqueUsername = $request->get('inputUsername');
      // dump($uniqueUsername);
      $entitym = $this->getDoctrine()->getManager();
      $demandeRepo = $entitym->getRepository('AppBundle:User');
      $occurenceUsername = $demandeRepo->uniqueField($uniqueUsername);

      return new Response(json_encode($occurenceUsername), 200, ['Content-Type' => 'application/json']);

   }
    /**
     * @Route("/admin/liste", name="listeAccount")
     */
    public function listeAccountAction()
    {
      $form = $this->createFormBuilder()
                  ->add('appelation', EntityType::class, array(
                     'class' => 'ApiBundle:Salon',
                     'choice_label' => 'appelation',
                     'label' => 'admin_create.salon',
                     'placeholder' => ' Choisir un salon',
                     'translation_domain' => 'admin_create'
                  ))
                ->getForm();

   return $this->render('admin/listeAccount.html.twig',['form'=>$form->createView(),'flash'=>null]);

    }

    /**
     * @Route("/admin/accountpaginate", name="adminAccountPaginate")
     */
    public function paginateAction(Request $request)
    {
      if(!$request->isMethod('post')){
        return $this->render('listeAccount.html.twig');
         };
      $length = $request->get('length');
      $length = $length && ($length != -1 ) ? $length : 0;

      $start = $request->get('start');
      $start = $length ? ($start && ($start !=-1 ) ? $start :0 ) / $length : 0;

      $search = $request->get('search');
      $filters = [
          'query' => @$search['value']
      ];

      $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();


      $output = array(
           'data' => array(),
           'recordsFiltered' => count($users),
           'recordsTotal' => count($users)
      );

      foreach ($users as $user) {


      $url= $this->generateUrl('editAccount', array('idUser' => $user->getId()));
      $userRole = $user->getRoles();

      //Condition pour déterminer l'état d'un compte
      if ($user->isEnabled()) { $state = "actif"; }else{ $state = "inactif"; }

      //Condition pour déterminer la date de dernière Connexion d'un compte
      if ($user->getCreation() == $user->getLastLogin()){
         $date = 'n/a';
       }else{
         $date = $user->getLastLogin();
         $date= $date->format('d-m-Y H:i');
       }
         if ($userRole[0] == 'ROLE_MANAGER' || $userRole[0] == 'ROLE_COORD'
         || $userRole[0] == 'ROLE_PAIE' || $userRole[0] == 'ROLE_JURIDIQUE'){

      $output['data'][] = [
          'id'               => $user->getId(),
          ''                 => '<a href ='.$url.'><span class="glyphicon glyphicon-search click"></span></a>',
          'User'             => $user->getUsername(),
          'Dernière Connexion'  => $date,
          'Rôle'             =>   $userRole[0],
          'Actif'            => '<span class="state '.$state.'"></span>',
        ];
           }
      }
      return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/admin/edit/{idUser}", name="editAccount")
     */
    public function editAccountAction(Request $request, $idUser)
    {
             $em= $this->getDoctrine()->getManager();
             $user = $em->getRepository('AppBundle:User')->find($idUser);
             if(!$user){
                     throw $this->createNotFoundException('Erreur, aucun utilisateur trouvé !');

             }
                      //Récupère les infos de l'User

                      $userState = $user->isEnabled();
                      $userRole = $user->getRoles();
                      $userMdp = $user->getPassword();

                      //On récupere le Personnel associé au compte
                      $userIdPersonnel = $user->getIdPersonnel();
                      $req= $this->getDoctrine()->getManager('referentiel');
                      $personnel = $req->getRepository('ApiBundle:Personnel')->findOneBy(array('matricule' => $userIdPersonnel));

                      //On recupere les infos du personnel dans le cas des comptes liés (manager)
                      if($user->getIdPersonnel() != 0){

                        $identitePersonnel = $personnel->getNom().' '.$personnel->getPrenom();

                     }else{
                        $identitePersonnel = null;
                     }
                      $formFactory = $this->container->get('fos_user.registration.form.factory');
                      $form = $formFactory->createForm();


                      $form ->add('plainPassword', HiddenType::class, array(
                                      'data' => $userMdp));
                      $form ->add('enabled', ChoiceType::class, array(
                              'choices'  => array('Activer' => 1,'Desactiver' => 0),
                              'expanded' => true,
                              'multiple' => false,
                              'data' => $userState,
                              'label' => 'admin_create.etat',
                              'translation_domain' => 'admin_create')
                                 );
                      $form ->add('roles', ChoiceType::class, array(
                               'choices' => array('Manager'=>'ROLE_MANAGER','Coordinateur' => 'ROLE_COORD', 'Service Paie' => 'ROLE_PAIE', 'Service Juridique' => 'ROLE_Juridique'),
                               'expanded' => false,
                               'multiple' => false,
                               'mapped' => false,
                               'data' => $userRole[0],
                               'label' => 'admin_create.role',
                               'translation_domain' => 'admin_create')
                            );
                      $form ->add('email', EmailType::class, array(
                               'required'  => false,
                               'label' => 'admin_create.email',
                               'translation_domain' => 'admin_create'));
                      $form-> add('Valider', SubmitType::class, array(
                            'label' => 'global.valider',
                            'translation_domain' => 'global',
                            'attr' => array(
                                 'class' => 'btn-black end'
                                   )
                                 )
                            );
                      $form->setData($user);

                   if ($request->isMethod('POST')) {

                           $form->handleRequest($request);

                           if ($form->isSubmitted()) {
                              //On enregistre les données principales
                              $task = $form->getData();
                              $em = $this->getDoctrine()->getManager();

                              //On mets à jour le de ce même User
                              $roles= $form["roles"]->getData();
                              $user->removeRole($userRole[0]);
                              $user->addRole($roles);

                              $em->persist($task);
                              $em->flush();

                           return $this->render('admin/listeAccount.html.twig', array(
                           'form' => $form->createView(),
                           'flash'=> 'Le compte a correctement modifié'));
                        }
                     }

         return $this->render('admin/editAccount.html.twig',['idUser' => $idUser,
                                                             'form' => $form->createView(),
                                                             'identitePersonnel' => $identitePersonnel
                                                          ]);
    }


    /**
     * @Route("/admin/changePassword/{idUser}", name="changePassword")
     */
    public function changePasswordAction(Request $request, $idUser)
    {
     $em= $this->getDoctrine()->getManager();
     $user = $em->getRepository('AppBundle:User')->find($idUser);
     if(!$user){
              throw $this->createNotFoundException('Erreur, aucun utilisateur trouvé !');

     }
      //On récupere le Personnel associé au compte
      // $userIdPersonnel = $user->getIdPersonnel();
      // $req= $this->getDoctrine()->getManager('referentiel');
      // $personnel = $req->getRepository('ApiBundle:Personnel')->findOneBy(array('matricule' => $userIdPersonnel));
      //
      // $identitePersonnel = $personnel->getNom().' '.$personnel->getPrenom();


      $formFactory = $this->get('fos_user.change_password.form.factory');

      $form = $formFactory->createForm(array('action' => $this->generateUrl('changePassword', array('idUser' => $idUser))));
      $form-> add('Changer', SubmitType::class, array(
            'label' => 'global.valider',
            'translation_domain' => 'global',
            'attr' => array(
                 'class' => 'btn-black end'
                   )
                 )
            );
            $form-> remove('current_password');

      $form->setData($user);

      $form->handleRequest($request);

         if ($form->isSubmitted() ) {
            $task = $form->getData();

              $em = $this->getDoctrine()->getManager();
              $em->persist($task);
              $em->flush();

               return $this->render('admin/listeAccount.html.twig', array(
               'form' => $form->createView(),
               'flash'=> 'Mot de passe correctement modifié'));
        }

        return $this->render('admin/changePassword.html.twig', array(
         'form' => $form->createView()
       ));
    }
}
