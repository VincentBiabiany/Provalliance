<?php
namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Routing\Router;
use Doctrine\ORM\EntityManager;
use ApiBundle\Entity\Personnel;
use ApiBundle\Entity\Salon;
use ApiBundle\Entity\Groupe;
use ApiBundle\Entity\Enseigne;
use ApiBundle\Entity\Pays;
use ApiBundle\Entity\PersonnelHasSalon;
use ApiBundle\Entity\Profession;
use AppBundle\Entity\DemandeSimple;
use AppBundle\Entity\DemandeComplexe;
use AppBundle\Entity\DemandeEmbauche;
use AppBundle\Entity\DemandeAcompte;

class DemandeService
{
  private $em;
  private $em2;
  private $mailer;
  private $token;
  private $templating;
  private $session;
  private $fileUploader;
  private $router;

  public function __construct(EntityManager $em, EntityManager $em2,
                              \Swift_Mailer $mailer, TokenStorage $token,
                              EngineInterface $templating, Session $session,
                              FileUploader $fileUploader,
                              Router $router)
  {
    $this->em           = $em;
    $this->em2          = $em2;
    $this->mailer       = $mailer;
    $this->token        = $token->getToken();
    $this->templating   = $templating;
    $this->session      = $session;
    $this->fileUploader = $fileUploader;
    $this->router       = $router;
  }

  public function createDemande($demande, $idSalon)
  {
    if ($demande instanceof DemandeAcompte) {
      self::createDemandeAcompte($demande, $idSalon);
    }

    if ($demande instanceof DemandeEmbauche) {
      self::createDemandeEmbauche($demande, $idSalon);
    }
  }
  /*         M   C   les 2
  * array -> 0,  1 , 2
  *          Paie  RH  Adm  rh+paie  paie + adm          tous
  *       -> 1,    2,  4,    3          5          6      7
  *
  */

  public function sendMail($idSalon, $personnel, $envoie, $demande)
  {
    // Notification par Mail
    // $destinataire = $this->em2->getRepository('AppBundle:User')
    //                           ->findOneBy(array('idPersonnel' => $personnel->getMatricule()));
    //
    // $destinataire = $destinataire->getEmail();

    $salon =  $this->em->getRepository('ApiBundle:Salon')
                       ->findOneBy(array('sage' => $idSalon));

    $coord = $this->em->getRepository('ApiBundle:PersonnelHasSalon')
                       ->findOneBy(array('salonSage' => $idSalon, 'profession' => 2));

    $coord != null ?  $coord = $coord->getPersonnelMatricule()->getMatricule() : $coord = null;

    $manager = $this->em->getRepository('ApiBundle:PersonnelHasSalon')
                        ->findOneBy(array('salonSage' => $idSalon, 'profession' => 1));
    $manager != null ?   $manager = $manager->getPersonnelMatricule()->getMatricule() : null;

    if ($manager) {
      $managerMail =  $this->em2->getRepository('AppBundle:User')
                          ->findOneBy(array('idPersonnel' => $manager));
      $managerMail != null ?  $managerMail = $managerMail->getEmail() : $managerMail = null;
    } else
      $managerMail = null;

    if ($coord) {
      $coordoMail = $this->em2->getRepository('AppBundle:User')
                          ->findOneBy(array('idPersonnel' => $coord));
      $coordoMail != null ?  $coordoMail = $coordoMail->getEmail() : $coordoMail = null;
    } else
      $coordoMail = null;

    $qb =  $this->em2->createQueryBuilder();
                  $qb->select('u')
                      ->from("AppBundle:User", 'u')
                      ->where($qb->expr()->like('u.roles', $qb->expr()->literal("%ROLE_ADMIN%")));


    $admin = $qb->getQuery()->getResult();

    $qb =  $this->em2->createQueryBuilder();
                  $qb->select('u')
                      ->from("AppBundle:User", 'u')
                      ->where($qb->expr()->like('u.roles', $qb->expr()->literal("%ROLE_JURIDIQUE%")));


    $juridique = $qb->getQuery()->getResult();


    $qb =  $this->em2->createQueryBuilder();
                  $qb->select('u')
                      ->from("AppBundle:User", 'u')
                      ->where($qb->expr()->like('u.roles', $qb->expr()->literal("%ROLE_PAIE%")));


    $paie = $qb->getQuery()->getResult();

    // Vérifie à qui envoyer l'email au niveau salon
    // Envoie au manager
    if ($envoie[0] == 0) {
      self::sendMailToSalon($personnel, $managerMail, $demande);
    }
    // Envoie au coordo
    if ($envoie[0] == 1) {
      self::sendMailToSalon($personnel, $coordoMail, $demande);
    }
    // Envoie au 2
    if ($envoie[0] == 2) {
      self::sendMailToSalon($personnel, $managerMail, $demande);
      self::sendMailToSalon($personnel, $coordoMail, $demande);
    }

    // Envoie au paie
    if ($envoie[1] == 1) {
      self::sendMailToBo($personnel, $paie, $demande);
    }
    // Envoie au RH
    if ($envoie[1] == 2) {
      self::sendMailToBo($personnel, $juridique, $demande);
    }
    // Envoie admin
    if ($envoie[1] == 4) {
      self::sendMailToBo($personnel, $admin, $demande);
    }
    // Envoie Paie et RH
    if ($envoie[1] == 3) {
      self::sendMailToBo($personnel, $paie, $demande);
      self::sendMailToBo($personnel, $juridique, $demande);
    }
    // Envoie Paie et admn
    if ($envoie[1] == 5) {
      self::sendMailToBo($personnel, $paie, $demande);
      self::sendMailToBo($personnel, $admin, $demande);
    }
    // Envoie RH et admn
    if ($envoie[1] == 6) {
      self::sendMailToBo($personnel, $juridique, $demande);
      self::sendMailToBo($personnel, $admin, $demande);
    }
    // Enoie au 3
    if ($envoie[1] == 7) {
      self::sendMailToBo($personnel, $paie, $demande);
      self::sendMailToBo($personnel, $admin, $demande);
      self::sendMailToBo($personnel, $juridique, $demande);
    }
  }

  public function sendMailToSalon($personnel, $to, $demande)
  {
    $user = $this->token->getUser();
    $emetteur = $user->getEmail();
    $name = $user->getUsername();

    if ($to && filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $message = (new \Swift_Message('Nouvelle '. $demande))
                    //->setFrom($emetteur)
                    ->setFrom("haidress.connection@gmail.com")
                    ->setTo($user->getEmail())
                    ->setBody(
                      $this->templating->render(
                        'emails/mail_salon.html.twig',
                        array('personnel' => $personnel->getPrenom().' '.$personnel->getNom(),
                        'user' => $name,
                        'demande' => $demande,
                        'url' => $this->url)
                      ),
                      'text/html'
                    );
        $this->mailer->send($message);
    }
  }

  public function sendMailToBo($personnel, $to, $demande)
  {
    $user = $this->token->getUser();
    $emetteur = $user->getEmail();

    if ($to) {
      foreach ($to as $key => $userTo) {
        if ($userTo->getEmail() && filter_var($userTo->getEmail(), FILTER_VALIDATE_EMAIL) ) {
          $message = (new \Swift_Message('Nouvelle '. $demande))
                      //->setFrom($emetteur)
                      ->setFrom("haidress.connection@gmail.com")
                      ->setTo($userTo->getEmail())
                      ->setBody(
                        $this->templating->render(
                          'emails/mail_bo.html.twig',
                          array('personnel' => $personnel->getPrenom().' '.$personnel->getNom(),
                          'user'    => $userTo->getUsername(),
                          'demande' => $demande,
                          'url'     => $this->url)
                        ),
                        'text/html'
                      );
           $this->mailer->send($message);
          }
      }
    }
  }
  public function generateAbsUrl($demande)
  {
    $this->url = $this->router->generate('demande_detail', ['id' => $demande->getId()], 0);
  }

  public function createDemandeAcompte($demande, $idSalon)
  {
    $personnel =  $this->em->getRepository('ApiBundle:Personnel')
                           ->findOneBy(array('matricule' => $demande->getIdPersonnel()));

    $demandeSimple = new DemandeSimple();

    $demande->setTypeForm("Demande d'acompte");

    $demandeSimple->setService('paie');
    $demandeSimple->setUser($this->token->getUser());
    $demandeSimple->setIdSalon($idSalon);
    $demandeSimple->setDemandeform($demande);

    $this->em2->persist($demandeSimple);
    $this->em2->flush();

    $this->session->getFlashBag()->add("success", "La demande d'acompte pour ".$personnel->getPrenom()." ".$personnel->getNom()." a correctement été envoyée ! Un mail vous sera envoyé une fois votre demande traitée.");

    // Generation de l'url
    self::generateAbsUrl($demandeSimple);

    self::sendMail($idSalon, $personnel, [1, 5],  $demande->getTypeForm());
  }

  public function createDemandeEmbauche($demande, $idSalon)
  {
    $demandeComplexe = new DemandeComplexe();
    $demandeComplexe->setService('juridique');
    $demandeComplexe->setUser($this->token->getUser());
    $demandeComplexe->setIdSalon($idSalon);

    //$demandeEmbauche = $form->getData();

    $fileName = $this->fileUploader->upload($demande->getCarteId());
    $demande->setCarteId($fileName);

    $fileName = $this->fileUploader->upload($demande->getCarteVitale());
    $demande->setCarteVitale($fileName);

    $fileName = $this->fileUploader->upload($demande->getRib());
    $demande->setRib($fileName);

    $fileName = $this->fileUploader->upload($demande->getDiplomeFile());
    $demande->setDiplomeFile($fileName);

    $fileName = $this->fileUploader->upload($demande->getMutuelle());
    $demande->setMutuelle($fileName);

    $demande->setTypeForm("Demande d'embauche");
    $demandeComplexe->setDemandeform($demande);

    // Notification par Mail
    // $destinataire = $em->getRepository('AppBundle:User')->findOneBy(array('idPersonnel' => $personnel->getId()));
    // $destinataire = $destinataire->getEmail();

    // $user = $this->token->getUser();
    // $emetteur = $user->getEmail();

    // if (in_array('ROLE_ADMIN', $user->getRoles(), true))
    // {
    //   $name = 'ADMIN';
    // } else {
    //   $name = $user->getUsername();
    // }
    // $message = (new \Swift_Message('Nouvelle demande d\'embauche '))
    //    ->setFrom('send@example.com')
    //    ->setTo('recipient@example.com')
    //    ->setBody(
    //        $this->templating->render(
    //            'emails/demande_acompte.html.twig',
    //            array('personnel' => $demande->getPrenom(). ' '.$demande->getNom(),
    //                   'user' => $name,
    //                   'demande' => 'd\'embauche'
    //                 )
    //        ),
    //        'text/html'
    //    );
    // $this->mailer->send($message);


    $this->em2->persist($demandeComplexe);
    $this->em2->flush();

    // Generation de l'url
    self::generateAbsUrl($demandeComplexe);

    if ($demande->getTypeContrat() == "embauche.cdd")
      self::sendMail($idSalon, $personnel, [2, 7],  $demande->getTypeForm());
    else
      self::sendMail($idSalon, $personnel, [2, 5],  $demande->getTypeForm());



    $this->session->getFlashBag()->add("success", "La demande d'embauche pour ".$demande->getPrenom()." ".$demande->getNom()."a correctement été envoyé ! Un mail vous sera envoyé une fois votre demande traité.");

  }

}