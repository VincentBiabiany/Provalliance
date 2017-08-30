<?php
namespace AppBundle\Controller\Admin;
use AppBundle\Entity\User;
use ApiBundle\Entity\Personnel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
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

           $personnel = new User();
           $form = $this->createForm(CreateAccountType::class, $personnel);
           $form->handleRequest($request);

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
