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

class EditAccountController extends Controller
{
  /**
    * @Route("/admin/edit/{idUser}", name="editAccount")
    */
    public function editAccountAction(Request $request, $idUser)
    {
      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('AppBundle:User')->find($idUser);

      if (!$user) {
        throw $this->createNotFoundException('Erreur, aucun utilisateur trouvé !');
      }

      //Récupère les infos de l'User
      $userState = $user->isEnabled();
      $userRole = $user->getRoles();
      $userMdp = $user->getPassword();

      //On récupere le Personnel associé au compte
      $userIdPersonnel = $user->getMatricule();
      $req = $this->getDoctrine()->getManager('referentiel');
      $personnel = $req->getRepository('ApiBundle:Personnel')->findOneBy(array('matricule' => $userIdPersonnel));

      //On recupere les infos du personnel dans le cas des comptes liés (manager)
      if ($user->getMatricule() != 0) {

        $identitePersonnel = $personnel->getNom().' '.$personnel->getPrenom();

      } else {
        $identitePersonnel = null;
      }

      $formFactory = $this->container->get('fos_user.registration.form.factory');
      $form = $formFactory->createForm();


      $form ->add('plainPassword', HiddenType::class, array(
      ));

      $form ->add('enabled', ChoiceType::class, array(
        'choices'  => array('Activer' => 1,'Desactiver' => 0),
        'expanded' => true,
        'multiple' => false,
        'data' => $userState,
        'label' => 'admin.edit.etat',
        'translation_domain' => 'translator')
      );

      if ($userIdPersonnel == null)
       $choices = array('Service Paie' => 'ROLE_PAIE', 'Service Juridique / RH' => 'ROLE_JURIDIQUE');
      else
       $choices = array('Manager'=>'ROLE_MANAGER','Coordinateur' => 'ROLE_COORD', 'Service Paie' => 'ROLE_PAIE', 'Service Juridique / RH' => 'ROLE_JURIDIQUE');

      $form ->add('roles', ChoiceType::class, array(
        'choices' => $choices,
        'expanded' => false,
        'multiple' => false,
        'mapped' => false,
        'data' => $userRole[0],
        'label' => 'admin.edit.role',
        'translation_domain' => 'translator')
      );

      $form ->add('email', EmailType::class, array(
        'required'  => false,
        'label' => 'admin.edit.email',
        'translation_domain' => 'translator'));

      $form-> add('Valider', SubmitType::class, array(
          'label' => 'global.valider',
          'translation_domain' => 'translator',
          'attr' => array(
            'class' => 'btn-black end'
          )
        ));

        $form->setData($user);

        if ($request->isMethod('POST')) {

          $form->handleRequest($request);

          if ($form->isSubmitted()) {
            //On enregistre les données principales
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();

            //On mets à jour le de ce même User
            $roles = $form["roles"]->getData();
            $user->removeRole($userRole[0]);
            $user->addRole($roles);

            if ($roles == 'ROLE_PAIE' || $roles == 'ROLE_JURIDIQUE' || $roles == 'ROLE_ADMIN') {
              $account = $em->getRepository('AppBundle:Account')->findOneBy(['matricule' => $user->getMatricule()]);
              if ($account)
                $em->remove($account);
              $user->setMatricule(null);
            }

            $em->persist($user);
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
}
