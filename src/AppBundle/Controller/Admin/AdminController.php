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
     * @Route("/admin/create", name="createAccount")
     */
    public function createAccountAction(Request $request)
    {
           $salon = new Salon();
           $form = $this->createFormBuilder($salon)
                       ->add('nom', EntityType::class, array(
                          'class' => 'ApiBundle:Salon',
                          'choice_label' => 'nom',
                          'label' => 'admin_create.nom',
                          'placeholder' => ' Choisir un salon',
                          'translation_domain' => 'admin_create'
                       ))
                        -> add('Suivant', SubmitType::class, array(
               'label' => 'Suivant',
               'attr' => array(
                     'class' => 'btn btn-primary'
                      )
                   ))
                     ->getForm()
                ;

        if ($request->isMethod('POST')) {
           $form->handleRequest($request);

           if ($form->isValid()) {
                 $task = $form['nom']->getData();
                 $idSalon = $task->GetId();

                 return $this->redirect($this->generateUrl('createAccountS2', array('id' => $idSalon)));


           }
      }
         return $this->render('admin/createAccount.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/createS2/{id}", name="createAccountS2")
     */
    public function createAccountActionS2(Request $request)
    {

            $personnel = new Personnel();
            $idSalon = $request->get('id');
            $formS2 = $this->createFormBuilder($personnel)
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
                           ->setParameter('idSalon', $idSalon);
                  },
                 'label' => 'demandeacompte.nom',
                 'translation_domain' => 'demandeacompte'
              ))
            ->add('Suivant', SubmitType::class, array(
                 'label' => 'demandeacompte.envoyer',
                 'attr' => array('class' =>'btn-black end'),
                 'translation_domain' => 'demandeacompte'
              ))
            ->getForm()
          ;
          if ($request->isMethod('POST')) {
             $formS2->handleRequest($request);

             if ($formS2->isValid()) {
                   $task = $formS2['nom']->getData();
                   $idPersonnel = $task->GetId();

                   return $this->redirect($this->generateUrl('createAccountS3', array('id' => $idPersonnel)));
             }
        }


          return $this->render('admin/createAccountS2.html.twig',['formS2'=>$formS2->createView()]);

    }

    /**
     * @Route("/admin/createS3/{id}", name="createAccountS3")
     */
   public function createAccountActionS3(Request $request)
   {
      $formFactory = $this->container->get('fos_user.registration.form.factory');
      $idPersonnel = $request->get('id');

      $formS3 = $formFactory->createForm();
      $formS3 ->add('idPersonnel', HiddenType::class, array(
                      'data' => $idPersonnel));
      $formS3 ->add('enabled', ChoiceType::class, array(
              'choices'  => array('Activer' => 1,'Desactiver' => 0),
                     'expanded' => true,
                     'multiple' => false));
      // $formS3 ->add('roles', ChoiceType::class, array(
      //          'choices' => array('Administrateur' => 'ROLE_ADMIN', 'Service Paie' => 'ROLE_PAIE', 'Service Juridique' => 'ROLE_Juridique'),
      //          'expanded' => false,
      //          'multiple' => false,
      //          'mapped' => true,
      //      )
      //  );
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

                if ($formS3->isValid()) {
                       $em = $this->getDoctrine()->getManager();

                        $user = new User();

                        $task = $formS3->getData();
                        $user ->setUsername('test');
                        $user ->setUsername('test');
                        $user ->setUsername('test');
                        $em->persist($user);
                        $em->flush();

                  //  return $this->redirect($this->generateUrl('adminHome'));
                      }
           }

            return $this->render('admin/createAccountS3.html.twig',['formS3'=>$formS3->createView()]);


   }

    /**
     * @Route("/admin/edit", name="editAccount")
     */
    public function editAccountAction()
    {
         return $this->render('admin/editAccount.html.twig');
    }
}
