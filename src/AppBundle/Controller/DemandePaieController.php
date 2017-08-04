<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DemandePaieController extends Controller
{
    /**
     * @Route("/paie", name="home_paie")
     */
    public function indexAction(Request $request)
    {
        return $this->render('home_paie.html.twig', array(
        ));
    }
}
