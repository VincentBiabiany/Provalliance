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
use AppBundle\Entity\AutreDemande;
use AppBundle\Entity\DemandeRib;

class DemandeService
{
  private $em;
  private $emWebapp;
  private $mailer;
  private $token;
  private $templating;
  private $session;
  private $fileUploader;
  private $router;

  public function __construct(EntityManager $em, EntityManager $emWebapp,
                              \Swift_Mailer $mailer, TokenStorage $token,
                              EngineInterface $templating, Session $session,
                              FileUploader $fileUploader,
                              Router $router)
  {
    $this->em           = $em;
    $this->emWebapp     = $emWebapp;
    $this->mailer       = $mailer;
    $this->token        = $token->getToken();
    $this->templating   = $templating;
    $this->session      = $session;
    $this->fileUploader = $fileUploader;
    $this->router       = $router;
  }

  public function createDemande($demande, $idSalon)
  {

    if ($demande instanceof AutreDemande || $demande instanceof DemandeAcompte
    || $demande instanceof DemandeRib) {
      self::createDemandeSimple($demande, $idSalon);
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
    $salon =  $this->em->getRepository('ApiBundle:Salon')
                       ->findOneBy(array('sage' => $idSalon));

    $coord = $this->em->getRepository('ApiBundle:PersonnelHasSalon')
                       ->findOneBy(array('salonSage' => $idSalon, 'profession' => 2));

    $coord != null ?  $coord = $coord->getPersonnelMatricule()->getMatricule() : $coord = null;

    $manager = $this->em->getRepository('ApiBundle:PersonnelHasSalon')
                        ->findOneBy(array('salonSage' => $idSalon, 'profession' => 1));
    $manager != null ?   $manager = $manager->getPersonnelMatricule()->getMatricule() : null;

    if ($manager) {
      $managerMail =  $this->emWebapp->getRepository('AppBundle:User')
                          ->findOneBy(array('matricule' => $manager));
      $managerMail != null ?  $managerMail = $managerMail->getEmail() : $managerMail = null;
    } else
      $managerMail = null;

    if ($coord) {
      $coordoMail = $this->emWebapp->getRepository('AppBundle:User')
                          ->findOneBy(array('matricule' => $coord));
      $coordoMail != null ?  $coordoMail = $coordoMail->getEmail() : $coordoMail = null;
    } else
      $coordoMail = null;

    $qb =  $this->emWebapp->createQueryBuilder();
                  $qb->select('u')
                      ->from("AppBundle:User", 'u')
                      ->where($qb->expr()->like('u.roles', $qb->expr()->literal("%ROLE_ADMIN%")));


    $admin = $qb->getQuery()->getResult();

    $qb =  $this->emWebapp->createQueryBuilder();
                  $qb->select('u')
                      ->from("AppBundle:User", 'u')
                      ->where($qb->expr()->like('u.roles', $qb->expr()->literal("%ROLE_JURIDIQUE%")));


    $juridique = $qb->getQuery()->getResult();


    $qb =  $this->emWebapp->createQueryBuilder();
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
      self::sendMailToBo($paie, $demande);
    }
    // Envoie au RH
    if ($envoie[1] == 2) {
      self::sendMailToBo($juridique, $demande);
    }

    // Envoie admin
    if ($envoie[1] == 4) {
      self::sendMailToBo($$admin, $demande);
    }
    // Envoie Paie et RH
    if ($envoie[1] == 3) {
      self::sendMailToBo($paie, $demande);
      self::sendMailToBo($juridique, $demande);
    }
    // Envoie Paie et admn
    if ($envoie[1] == 5) {
      self::sendMailToBo($paie, $demande);
      self::sendMailToBo($admin, $demande);
    }
    // Envoie RH et admn
    if ($envoie[1] == 6) {
      self::sendMailToBo($juridique, $demande);
      self::sendMailToBo($admin, $demande);
    }
    // Enoie au 3
    if ($envoie[1] == 7) {
      self::sendMailToBo($paie, $demande);
      self::sendMailToBo($admin, $demande);
      self::sendMailToBo($juridique, $demande);
    }
  }

  public function sendMailToSalon($personnel, $to, $demande)
  {
    $user = $this->token->getUser();
    $emetteur = $user->getEmail();
    $manager = $this->em->getRepository('ApiBundle:Personnel')->findOneBy(['matricule' => $user->getMatricule()]);

    if ($manager == null)
      $manager = "Admin";
    else
      $manager = $manager->getPrenom() . ' ' . $manager->getNom();

    if ($to && filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $message = (new \Swift_Message('Nouvelle '. $demande))
                    //->setFrom($emetteur)
                    ->setFrom("haidress.connection@gmail.com")
                    ->setTo($user->getEmail())
                    ->setBody(
                      $this->templating->render(
                        'emails/mail_salon.html.twig',
                        array(
                        'user'      => $manager,
                        'personnel' => $personnel,
                        'demande'   => $demande,
                        'url'       => $this->url)
                      ),
                      'text/html'
                    );
        $this->mailer->send($message);
    }
  }

  public function sendMailToBo($to, $demande)
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
                          array(
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

  public function createDemandeSimple($demande, $idSalon){

    $personnel =  $this->em->getRepository('ApiBundle:Personnel')
                           ->findOneBy(array('matricule' => $demande->getMatricule()));

    $demandeSimple = new DemandeSimple();

    $demande->setTypeForm( $demande->getTypeForm());

    $demandeSimple->setService($demande->getService());
    $demandeSimple->setUser($this->token->getUser());
    $demandeSimple->setIdSalon($idSalon);

    $demandeSimple->setDemandeform($demande);

    $this->emWebapp->persist($demandeSimple);
    $this->emWebapp->flush();

    // Generation de l'url
    self::generateAbsUrl($demandeSimple);

    if (  $personnel == null){
      $personnel ='n/a';

    }else{
      $personnel = $personnel->getPrenom().' '.$personnel->getNom();
      self::sendMail($idSalon, $personnel, [1, 5],  $demande->getTypeForm());
    }


  }

  public function createDemandeEmbauche($demande, $idSalon)
  {
    $demandeComplexe = new DemandeComplexe();
    $demandeComplexe->setService('juridique');
    $demandeComplexe->setUser($this->token->getUser());
    $demandeComplexe->setIdSalon($idSalon);

    //$demandeEmbauche = $form->getData();

    $fileName = $this->fileUploader->upload($demande->getCarteId(), 0, 'embauche', 'ID');
    $demande->setCarteId($fileName);

    $fileName = $this->fileUploader->upload($demande->getCarteVitale(), 0, 'embauche', 'ACV');
    $demande->setCarteVitale($fileName);

    $fileName = $this->fileUploader->upload($demande->getRib(), 0, 'embauche', 'RIB');
    $demande->setRib($fileName);

    $fileName = $this->fileUploader->upload($demande->getDiplomeFile(), 0, 'embauche', 'DPLM1');
    $demande->setDiplomeFile($fileName);

    if ($demande->getDiplomeFile2() != null || $demande->getDiplomeFile2() != '')
    {
      $fileName = $this->fileUploader->upload($demande->getDiplomeFile2(), 0, 'embauche', 'DPLM2');
      $demande->setDiplomeFile2($fileName);
    }

    $fileName = $this->fileUploader->upload($demande->getMutuelle(), 0, 'embauche', 'AM');
    $demande->setMutuelle($fileName);

    $demande->setTypeForm("Demande d'embauche");
    $demandeComplexe->setDemandeform($demande);

    $personnel = $demande->getPrenom(). ' '.$demande->getNom();

    $this->emWebapp->persist($demandeComplexe);
    $this->emWebapp->flush();

    // Generation de l'url
    self::generateAbsUrl($demandeComplexe);

    if ($demande->getTypeContrat() == "demande_embauche.cdd")
      self::sendMail($idSalon, $personnel, [2, 7],  $demande->getTypeForm());
    else
      self::sendMail($idSalon, $personnel, [2, 5],  $demande->getTypeForm());

    $this->session->getFlashBag()->add("success", "La demande d'embauche pour ".$personnel." a correctement été envoyé ! Un mail vous sera envoyé une fois votre demande traité.");
  }

}
