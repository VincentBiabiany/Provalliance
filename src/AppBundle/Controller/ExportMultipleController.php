<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\ExportService;



class ExportMultipleController extends Controller
{
  /**
   * @Route("/exportXls", name="exportXls")
   */
  public function exportXls(Request $request, ExportService $exportService)
  {
      $formData = $request->get('form');
      $demandeExports = explode(',',$formData['idDemandes']);

      // On récupère le service
      return $exportService->createExcel($demandeExports);

  }

}
