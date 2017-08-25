<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use AppBundle\Form\Admin\CreateAccountType;

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
      $formFactory = $this->container->get('fos_user.registration.form.factory');

      $form = $formFactory->createForm();
      $form ->add('salon', EntityType::class, array(
           'class' => 'ApiBundle:Salon',
           'choice_label' => 'nom',
           'label' => 'admin_create.nom',
           'translation_domain' => 'admin_create'
          ))
      ->add('personnel', NumberType::class, array(
             'label' => 'admin_create.personnel',
             'translation_domain' => 'admin_create'
           ))
      ->add('enabled', ChoiceType::class, array(
                'choices'  => array('Activer' => 1,'Desactiver' => 0),
                       'expanded' => true,
                       'multiple' => false))
      ->add('Valider', SubmitType::class, array(
             'label' => 'Créer un utilisateur',
             'translation_domain' => 'FOSUserBundle',
             'attr' => array(
                    'class' => 'btn btn-primary'
                     )
                    )
               );

        if ($request->isMethod('POST')) {
           $form->handleRequest($request);

           if ($form->isValid()) {
                 $task = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

             return $this->redirect($this->generateUrl('homepage'));
           }
      }


         return $this->render('admin/createAccount.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/admin/edit", name="editAccount")
     */
    public function editAccountAction()
    {

         return $this->render('admin/editAccount.html.twig');
    }

}
