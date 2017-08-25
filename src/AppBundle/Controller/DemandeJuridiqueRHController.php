<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DemandeJuridiqueRHController extends Controller
{
    /**
     * @Route("/juridique_rh", name="home_juridique_rh")
     */
    public function indexAction(Request $request)
    {
      $img = $request->getSession()->get('img');
      return $this->render('home_juridique_rh.html.twig', array(
        'img' => $img
      ));
    }
}
