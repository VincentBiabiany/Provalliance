<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\DemandeEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ValidationController extends Controller
{
  /**
   * @Route("/demandeValidate", name="demandeValidate")
   */
  public function demandeValidate(Request $request)
  {
    $demandeValidates = $request->get('demandes');
    $nbValidates = $request->get('nbValidates');
    $entitym = $this->getDoctrine()->getManager();
    foreach ($demandeValidates as $demandeValidate ) {
        $demande = $entitym->getRepository('AppBundle:DemandeEntity')
                            ->findOneBy(array('id' => $demandeValidate));

        $demande->setStatut(2);
        $this->getDoctrine()->getManager()->flush();
      }

      return new Response($this->generateUrl('demandeShow',['origin' => 'validation','nb'=>$nbValidates]));

  }

}
