<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ApiBundle\Entity\Personnel;

class HomeController extends Controller
{
  /**
  * @Route("/", name="homepage")
  */
  public function indexAction(Request $request)
  {
    if ($request->get('flash')) {
      $flash = $request->get('flash');
    } else {
      $flash = null;
    }

    if (in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true)) {

      $em        = $this->getDoctrine()->getManager('referentiel');
      $salons    = $em->getRepository('ApiBundle:Salon')->findAllActiveSalon();

      $personnel = new Personnel();
      $personnel->setNom('Admin');
      $personnel->setPrenom('');


      dump($salons);

      //Si un service tente d'accéder a la home on le redirige vers le suivi des demandes
    } else if (in_array('ROLE_PAIE', $this->getUser()->getRoles(), true) ||
     (in_array('ROLE_JURIDIQUE', $this->getUser()->getRoles(), true))) {

      return $this->redirect($this->generateUrl('demande'));

    } else {
      $idPersonnnel = $this->getUser()->getIdPersonnel();
      $em = $this->getDoctrine()->getManager('referentiel');
      $personnel = $em->getRepository('ApiBundle:Personnel')->findOneBy(array('matricule' => $idPersonnnel));
      $salons = $personnel->getSalon();
    }

    return $this->render('home.html.twig', [
      'salons'=>$salons,
      'personnel'=>$personnel,
      'flash' =>$flash
    ]);

  }

  /**
  * @Route("/selected_salon", name="selected_salon")
  */
  public function SelectedSalonAction(Request $request)
  {
    if ($request->isXmlHttpRequest()) {
      $idSalon = $request->request->get("idSalon");
      $request->getSession()->set("idSalon", $idSalon);
      $img = $request->request->get("img");
      $request->getSession()->set("img", $img);
      $numero = $request->request->get("numero");
      $request->getSession()->set("numero", $numero);
      $nomSalon = $request->request->get("nomSalon");
      $request->getSession()->set("nomSalon", $nomSalon);
    }
    return new Response("ok", 200, ['Content-Type' => 'application/json']);
  }

}
