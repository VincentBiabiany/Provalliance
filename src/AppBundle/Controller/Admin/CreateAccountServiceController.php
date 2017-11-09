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

class CreateAccountServiceController extends Controller
{
/**
  * @Route("/admin/create_service", name="createAccountService")
  */
public function createAccountServiceAction(Request $request)
{
  $formFactory = $this->container->get('fos_user.registration.form.factory');
  $form = $formFactory->createForm( array('action' => $this->generateUrl('createAccountService')));
  $form ->add('matricule', HiddenType::class, array(
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
}
