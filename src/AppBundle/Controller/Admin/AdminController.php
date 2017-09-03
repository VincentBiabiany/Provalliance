<?php
namespace AppBundle\Controller\Admin;
use AppBundle\Entity\User;
use ApiBundle\Entity\Salon;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
           //CREATION DU 1ER FORM
           $idsalon =$request->request->get('id');
           $idsalon ="5";
           $task = null;
           $form = $this->createForm(CreateAccountType::class, $task, array('idsalon' => $idsalon));

           //CREATION DU 2EME FORM
           $formFactory = $this->container->get('fos_user.registration.form.factory');
           $form2 = $formFactory->createForm();

           $form2 ->add('enabled', ChoiceType::class, array(
                   'choices'  => array('Activer' => 1,'Desactiver' => 0),
                          'expanded' => true,
                          'multiple' => false));
           $form2 -> add('Valider', SubmitType::class, array(
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
         return $this->render('admin/createAccount.html.twig',['form'=>$form->createView(),'form2'=>$form2->createView()]);
    }


    /**
     * @Route("/admin/edit", name="editAccount")
     */
    public function editAccountAction()
    {
         return $this->render('admin/editAccount.html.twig');
    }
}
