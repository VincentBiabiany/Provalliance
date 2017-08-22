<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;

class PersonnelController extends FOSRestController
{
	public function personnelAction()
    {
		$em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        $data = array("hello" => $users);
        $view = $this->view($data);
        return $this->handleView($view);
    }
}