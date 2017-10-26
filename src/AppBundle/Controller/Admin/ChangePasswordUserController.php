<?php
namespace AppBundle\Controller\Admin;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
use AppBundle\Entity\User;


class ChangePasswordUserController extends Controller
{
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
        $formFactory = $this->get('fos_user.change_password.form.factory');

        $form = $formFactory->createForm(array('action' => $this->generateUrl('changePassword', array('idUser' => $idUser))));
        $form-> add('Changer', SubmitType::class, array(
              'label' => 'global.valider',
              'translation_domain' => 'global',
              'attr' => array(
                   'class' => 'btn-black end'
                     ))
              );
        $form->remove('current_password');
        $form->setData($user);
        $form->handleRequest($request);

           if ($form->isSubmitted() ) {
             /** @var $userManager UserManagerInterface */
             $userManager = $this->get('fos_user.user_manager');
             $event = new FormEvent($form, $request);
             $userManager->updateUser($user);

                 return $this->render('admin/listeAccount.html.twig', array(
                 'form' => $form->createView(),
                 'flash'=> 'Mot de passe correctement modifié'));
          }

          return $this->render('admin/changePassword.html.twig', array(
           'form' => $form->createView()
         ));
      }

}
