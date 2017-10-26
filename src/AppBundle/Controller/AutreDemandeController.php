<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\AutreDemande;
use AppBundle\Entity\Demande;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\AutreDemandeType;

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
    $form = $this->createForm(AutreDemandeType::class, $AutreDemande);
    $form->handleRequest($request);

    $img = $request->getSession()->get('img');
    if ($form->isSubmitted() && $form->isValid()) {

      $validator = $this->get('validator');
      $errors = $validator->validate($form);

      if (count($errors) > 0) {
        $errorsString = (string) $errors;
        return $this->render('autre_demande.html.twig',
                              array(
                                  'img' => $img,
                                  'form' => $form->createView(),
                                  'errors' => $errorsString
                                )
                              );
    } else {

      $demande = new Demande();
      $acompte = new AutreDemande();
      $em = $this->getDoctrine()->getManager();

      $this->addFlash("success", "Votre demande a bien été prise en compte.");
      return $this->redirectToRoute('homepage');
    }
  }
  return $this->render('autre_demande.html.twig', array(
    'img' => $img,
    'form' => $form->createView(),
    'errors' => null
  )
);
}
}
