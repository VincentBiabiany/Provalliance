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

class ListAccountController extends Controller
{
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
     $entitym = $this->getDoctrine()->getManager();
     $userRepo = $entitym->getRepository('AppBundle:User');

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
       $date= $date->format('d-m-Y');
      }
       if ($userRole[0] == 'ROLE_MANAGER' || $userRole[0] == 'ROLE_COORD'
       || $userRole[0] == 'ROLE_PAIE' || $userRole[0] == 'ROLE_JURIDIQUE'){


           $labelRole = $userRepo->getlabelRole($userRole[0]);

     $output['data'][] = [
         'id'                  => $user->getId(),
         ''                    => '<a href ='.$url.'><span class="glyphicon glyphicon-search click"></span></a>',
         'User'                => $user->getUsername(),
         'Dernière Connexion'  => $date,
         'Rôle'                =>  $labelRole,
         'Actif'               => '<span class="state '.$state.'"></span>',
      ];
          }
     }
     return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
  }


}
