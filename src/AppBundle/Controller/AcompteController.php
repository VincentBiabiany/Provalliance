<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\DemandeAcompte;
use AppBundle\Entity\Demande;
use AppBundle\Entity\RibSalarie;
use AppBundle\Form\DemandeAcompteType;
class AcompteController extends Controller
{
    /**
     * @Route("/paie/acompte", name="acompte")
     */
    public function indexAction(Request $request)
    {
      $img = $request->getSession()->get('img');
      $idSalon = $request->getSession()->get('idSalon');

      $demandeacompte = new DemandeAcompte();
      $form = $this->createForm(DemandeAcompteType::class, $demandeacompte, array("idSalon" => $idSalon));
      $form->handleRequest($request);

      $img = $request->getSession()->get('img');
              if ($form->isSubmitted() && $form->isValid()) {

                $validator = $this->get('validator');
                $errors = $validator->validate($form);
                    if (count($errors) > 0) {


                            $errorsString = (string) $errors;
                            return $this->render('paie_acompte.html.twig', array(
                                   'img' => $img,
                                   'form' => $form->createView(),
                                   'errors' => $errorsString
                               )
                            );


                        }else{

                            $demande = new Demande();
                            $acompte = new DemandeAcompte();
                            $em = $this->getDoctrine()->getManager();

                            $montant = $form["montant"]->getData();
                            dump($form);
                            $personnel = $form["idPersonnel"]->getData();

                            $acompte->setTypeForm("Demande d'acompte");
                            $acompte->setMontant($montant)->setIdPersonnel($personnel->getId());

                            $demande->setService('paie');
                            $demande->setUser($this->getUser());
                            $demande->setIdSalon($idSalon);
                            $demande->setDemandeform($acompte);

                            $em->persist($demande);
                            $em->flush();

                            $this->addFlash("success", "La demande d'acompte pour ".$personnel->getNom()." a correctement été envoyé ! Un mail vous sera envoyé une fois votre demande traité.");
                            return $this->redirectToRoute('homepage');
                            }
                    }
       return $this->render('paie_acompte.html.twig', array(
              'img' => $img,
              'form' => $form->createView(),
              'errors' => null
          )
       );
    }
}
