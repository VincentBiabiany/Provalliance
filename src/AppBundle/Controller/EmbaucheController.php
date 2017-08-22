<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmbaucheController extends Controller
{
    /**
     * @Route("/embauche", name="rh_embauche")
     */
    public function indexAction(Request $request)
    {
        return $this->render('embauche.html.twig', array(

            )
        );
    }
}
