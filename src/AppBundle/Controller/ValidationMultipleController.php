<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\DemandeEntity;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Entity\DemandeComplexe;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Form\DemandeAcompteType;
use AppBundle\Form\DemandeEmbaucheType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ValidationMultipleController extends Controller
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
