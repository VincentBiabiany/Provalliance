<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\ImpressionService;



class ImpressionController extends Controller
{

  /**
   * @Route("/printMultiple", name="printMultiple")
   */
  public function printMultiple(Request $request, ImpressionService $impressionService)
  {

    // On récupère le service
    $response = $impressionService->printGenerate(  $request->get('id'));
    return new Response(json_encode($response), 200, ['Content-Type' => 'application/json']);


  }

}
