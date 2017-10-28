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

}
