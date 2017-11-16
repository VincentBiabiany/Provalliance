<?php
namespace AppBundle\Controller\Demandes;
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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Form\AutreDemandeType;
use AppBundle\Service\DemandeService;


class AutreDemandeController extends Controller
{
  /**
  * @Route("/autre_demande", name="autre_demande")
  */
  public function indexAction(Request $request, DemandeService $demandeService)
  {
    $img = $request->getSession()->get('img');
    $idSalon = $request->getSession()->get('idSalon');

    //Génération de liste des personnels du salon + champs vide
    $entity = $this->getDoctrine()->getManager('referentiel');
    $personnelRepo = $entity->getRepository('ApiBundle:Personnel');
    $listePerso = $personnelRepo->getListPerso($idSalon);

    $AutreDemande = new AutreDemande();
    $form = $this->createForm(AutreDemandeType::class, $AutreDemande, array("idSalon" => $idSalon,"listePerso" => $listePerso));
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $demandeService->createDemande($form->getData(), $idSalon);

      return $this->redirect($this->generateUrl('homepage',
      array('flash' => "autre_demande.popupValidation.message")));
      }


    return $this->render('demandes/autre_demande.html.twig', array(
      'img' => $img,
      'form' => $form->createView(),
      'errors' => null
    ));
  }
}
