<?php
//
namespace AppBundle\Admin\Repository;
use Doctrine\ORM\EntityRepository;

class AccountRepository extends EntityRepository
{

  public function getPersonnelBySalon($idsalon) {
        //recupere tout le personnel du salon ayant pour id $idsalon
        $em = $this->getDoctrine()->getManager("referentiel");
        $listes = $em->getRepository('ApiBundle:Personnel')
                    ->findBy(array('salon' => $idsalon));

        //supprime les personnels ayant deja un compte utilisateur
        foreach ($listes as $Personnel ) {
          $em2 = $this->getDoctrine()->getManager()->getRepository('AppBundle:Account');

              if ( $Personnel->getEtat() == 1){
                    unset($listes[$Personnel]);

              }

        }
        return listes;
    }


  public function getState($idsalon) {

  }

}
