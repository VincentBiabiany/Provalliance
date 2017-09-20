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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityRepository;

class AdminController extends Controller
{
  /**
    * @Route("/admin", name="adminHome")
    */
   public function indexAction()
   {
        return $this->render('admin/home.html.twig');
   }
   /**
     * @Route("/admin/create_type", name="createType")
     */
    public function createTypeAction(Request $request)
    {

         return $this->render('admin/createType.html.twig');
    }
   /**
     * @Route("/admin/create", name="createAccount")
     */
    public function createAccountAction(Request $request)
    {

         return $this->render('admin/createAccount.html.twig');
    }

    /**
     * @Route("/admin/createS1", name="createAccountS1")
     */
    public function createAccountActionS1(Request $request)
    {
      $form = $this->createFormBuilder()
                  ->add('nom', EntityType::class, array(
                     'class' => 'ApiBundle:Salon',
                     'choice_label' => 'nom',
                     'label' => 'admin_create.nom',
                     'placeholder' => ' Choisir un salon',
                     'multiple' => true,
                     'translation_domain' => 'admin_create'
                  ))
                ->getForm()
           ;
           return $this->render('admin/createAccountS1.html.twig',['form'=>$form->createView()]);

    }
    /**
     * @Route("/admin/createS2/{id}", name="createAccountS2")
     */
    public function createAccountActionS2(Request $request)
    {
            $personnel = new Personnel();
            $idSalon = $request->get('id');
            //On sauvegarde le salon en cas de retour en arrière
            $request->getSession()->set("idSalonAdmin", $idSalon);

            $formS2 = $this->createFormBuilder()
            ->add('nom', EntityType::class, array(
                 // query choices from this entity
                 'class' => 'ApiBundle:Personnel',
                 // use the User.username property as the visible option string
                 'choice_label' => function ($personnel) {
                       return $personnel->getNom() ." ". $personnel->getPrenom();
                     },
                 'query_builder' => function (EntityRepository $er) use ($idSalon) {
                     return $er->createQueryBuilder('p')
                           ->join('p.salon', 'm')
                           ->where('m.id = :idSalon')
                           ->andWhere('p.compte = 0')
                           ->setParameter('idSalon', $idSalon);
                  },
                 'label' => 'demandeacompte.nom',
                 'translation_domain' => 'demandeacompte'
              ))
            ->getForm()
          ;
          return $this->render('admin/createAccountS2.html.twig',['formS2'=>$formS2->createView()]);
    }

    /**
     * @Route("/admin/createS3/{id}", name="createAccountS3")
     */
   public function createAccountActionS3(Request $request)
   {
      $formFactory = $this->container->get('fos_user.registration.form.factory');
      $idSalon = $request->get('id');

      $formS3 = $formFactory->createForm( array('action' => $this->generateUrl('createAccountS3', array('id' => $idSalon))));

      $formS3 ->add('idSalon', HiddenType::class, array(
                      'data' => $idSalon));
      $formS3 ->add('enabled', ChoiceType::class, array(
              'choices'  => array('Activer' => 1,'Desactiver' => 0),
                     'expanded' => true,
                     'multiple' => false));
      $formS3-> add('Valider', SubmitType::class, array(
            'label' => 'Créer un utilisateur',
            'translation_domain' => 'FOSUserBundle',
            'attr' => array(
                  'class' => 'btn btn-primary'
                   )
                  )
            );



            if ($request->isMethod('POST')) {
                $formS3->handleRequest($request);

                if ($formS3->isSubmitted()) {

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

                       $em->persist($newUser);
                       $em->flush();

                   $this->addFlash("success", "Le compte Manager a correctement été crée !");
                   return $this->redirect($this->generateUrl('adminHome'));
                      }
           }

            return $this->render('admin/createAccountS3.html.twig',['formS3'=>$formS3->createView()]);


   }

    /**
     * @Route("/admin/liste", name="listeAccount")
     */
    public function listeAccountAction()
    {

      $form = $this->createFormBuilder()
                  ->add('nom', EntityType::class, array(
                     'class' => 'ApiBundle:Salon',
                     'choice_label' => 'nom',
                     'label' => 'admin_create.nom',
                     'placeholder' => ' Choisir un salon',
                     'translation_domain' => 'admin_create'
                  ))
                ->getForm()
           ;

   return $this->render('admin/listeAccount.html.twig',['form'=>$form->createView()]);

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

      $date = $user->getLastLogin();
      $url= $this->generateUrl('editAccount', array('idUser' => $user->getId()));
      $userRole = $user->getRoles();
      if ($user->isEnabled())
      {
         $state = "actif";
      }else{
         $state = "inactif";
      }
      $output['data'][] = [
          'id'               => $user->getId(),
          ''                 => '<a href ='.$url.'><span class="glyphicon glyphicon-search click"></span></a>',
          'User'             => $user->getUsername(),
          'Dernière Connexion'  => $date->format('d-m-Y H:i'),
          'Rôle'             =>    $userRole[0],
          'Actif'            => '<span class="state '.$state.'"></span>',
        ];
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
                      $personnel = $req->getRepository('ApiBundle:Personnel')->findOneBy(array('id' => $userIdPersonnel));

                      $identitePersonnel = $personnel->getNom().' '.$personnel->getPrenom();
                      $formFactory = $this->container->get('fos_user.registration.form.factory');
                      $form = $formFactory->createForm();


                      $form ->add('plainPassword', HiddenType::class, array(
                                      'data' => $userMdp));
                      $form ->add('enabled', ChoiceType::class, array(
                              'choices'  => array('Activer' => 1,'Desactiver' => 0),
                                    'expanded' => true,
                                    'multiple' => false,
                                    'data' => $userState)
                                 );
                      $form ->add('roles', ChoiceType::class, array(
                               'choices' => array('Administrateur' => 'ROLE_ADMIN', 'Service Paie' => 'ROLE_PAIE', 'Service Juridique' => 'ROLE_Juridique'),
                               'expanded' => false,
                               'multiple' => false,
                               'mapped' => false,
                               'data' => $userRole[0])
                            );
                      $form-> add('Valider', SubmitType::class, array(
                            'label' => 'Valider',
                            'translation_domain' => 'FOSUserBundle',
                            'attr' => array(
                                 'class' => 'btn btn-primary'
                                   )
                                 )
                            );
                      $form->setData($user);

                   if ($request->isMethod('POST')) {

                           $form->handleRequest($request);

                           if ($form->isValid()) {
                              //On enregistre les données principales
                              $task = $form->getData();
                              $em = $this->getDoctrine()->getManager();

                              //On mets à jour le de ce même User
                              $roles= $form["roles"]->getData();
                              $user->removeRole($userRole[0]);
                              $user->addRole($roles);

                              $em->persist($task);
                              $em->flush();



             	            return $this->redirect($this->generateUrl('listeAccount'));

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
      $userIdPersonnel = $user->getIdPersonnel();
      $req= $this->getDoctrine()->getManager('referentiel');
      $personnel = $req->getRepository('ApiBundle:Personnel')->findOneBy(array('id' => $userIdPersonnel));

      $identitePersonnel = $personnel->getNom().' '.$personnel->getPrenom();


      $formFactory = $this->get('fos_user.change_password.form.factory');

      $form = $formFactory->createForm();
      $form-> add('Changer', SubmitType::class, array(
            'label' => 'Changer',
            'translation_domain' => 'FOSUserBundle',
            'attr' => array(
                 'class' => 'btn btn-primary'
                   )
                 )
            );
            $form-> remove('current_password');

      $form->setData($user);

      $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

              $em = $this->getDoctrine()->getManager();
              $em->persist($task);
              $em->flush();

            $this->addFlash("success", "Mot de passe correctement modifié");
            return $this->redirect($this->generateUrl('listeAccount'));

        }

        return $this->render('admin/change_password.html.twig', array(
         'form' => $form->createView(),
         'identitePersonnel' => $identitePersonnel
      ));
    }
}
