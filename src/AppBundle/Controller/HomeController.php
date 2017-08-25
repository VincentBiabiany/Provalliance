<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

      $idPersonnnel = $this->getUser()->getIdPersonnel();
      $em = $this->getDoctrine()->getManager('referentiel');
      $personnel = $em->getRepository('ApiBundle:Personnel')->findOneBy(array('id' => $idPersonnnel));
      $salons = $personnel->getSalon();

      return $this->render('home.html.twig', [
          'salons'=>$salons
      ]);
    }

    /**
     * @Route("/selected_salon", name="selected_salon")
     */
    public function SelectedSalonAction(Request $request)
    {
      if($request->isXmlHttpRequest()) {
        $idSalon = $request->request->get("idSalon");
        $request->getSession()->set("idSalon", $idSalon);

        $img = $request->request->get("img");
        $request->getSession()->set("img", $img);
      }
      return new Response("ok", 200, ['Content-Type' => 'application/json']);
    }

}
