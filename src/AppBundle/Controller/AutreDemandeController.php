<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\AutreDemande;
use AppBundle\Entity\Demande;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AutreDemandeController extends Controller
{
  /**
  * @Route("/autre_demande", name="autre_demande")
  */
  public function indexAction(Request $request,\Swift_Mailer $mailer)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');
    $AutreDemande = new AutreDemande();

      $entity = $this->getDoctrine()->getManager('referentiel');
      $personnelRepo = $entity->getRepository('ApiBundle:Personnel');
      $listePerso = $personnelRepo->getListPerso($idSalon);

      $form = $this->createFormBuilder()
      ->add('idPersonnel', ChoiceType::class, array(
            'choices' => $listePerso,
            'label' => 'admin_create.nom',
            'translation_domain' => 'admin_create'
           ))
         ->add('service', ChoiceType::class, array(
                  'choices' => array('Service Paie' => 'paie', 'Service Juridique' => 'Juridique',
                  'Service Informatique' => 'Informatique'),
                  'expanded' => false,
                  'multiple' => false,
                  'mapped' => false,
              ))
         ->add('objet', TextType::class, array(
             'label' => 'autredemande.objet',
             'translation_domain' => 'autre_demande',
           ))
           ->add('pieceJointes', FileType::class, array(
               'required'  => false))

         ->add('commentaire', TextareaType::class, array(
                       'label' => 'autredemande.commentaire',
                       'translation_domain' => 'autre_demande',
                       'attr' => array('rows' => '5')
           ))
                ->add('Envoyer', SubmitType::class, array(
                     'label' => 'autredemande.envoyer',
                     'attr' => array('class' =>'btn-black end'),
                     'translation_domain' => 'autre_demande'
                   ))
                   ->getForm();


      $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      // $demande = new Demande();
      // $acompte = new AutreDemande();
      // $em = $this->getDoctrine()->getManager();

      return $this->redirect($this->generateUrl('homepage', array('flash' => 'Votre demande a bien été prise en compte.')));
  }
  return $this->render('autre_demande.html.twig', array(
    'img' => $img,
    'form' => $form->createView(),
  ));
}
}
