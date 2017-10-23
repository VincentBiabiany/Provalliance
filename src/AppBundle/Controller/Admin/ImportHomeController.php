<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin/importHome", name="importHome")
 */
class ImportHomeController extends Controller
{
  public function indexAction(Request $request)
  {
    return $this->render('admin/import/import_home.html.twig', []);
  }

}
