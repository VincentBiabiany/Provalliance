<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\ResumeDemandeService;



class ImpressionController extends Controller
{

  /**
   * @Route("/printMultiple", name="printMultiple")
   */
  public function printMultiple(Request $request, ResumeDemandeService $ResumeDemandeService)
  {

    // On récupère le service
    $rep = $ResumeDemandeService->generateResume(  $request->get('id'));

     $response = new Response(json_encode($rep), 200, ['Content-Type' => 'application/json']);

     $response->setCharset('utf-8');

     return $response;

  }

}
