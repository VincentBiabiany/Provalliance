<?php
namespace AppBundle\Controller\Admin;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\ImportService;

/**
 * @Route("/admin/importHome", name="importHome")
 */
class ImportHomeController extends Controller
{
   public function indexAction(Request $request, ImportService $import)
   {
     $form = $this->createFormBuilder()
     ->add('salon', FileType::class, array('required' => false))
     ->add('personnel', FileType::class, array('required' => false))
     ->add('lien', FileType::class, array('required' => false))
     ->add('send', SubmitType::class)
     ->getForm();

     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
       $data = $form->getData();

       if($data['salon'])
        $import->importSalon($data['salon']);
        
       if($data['personnel'])
        $import->importPersonnel($data['personnel']);

       if($data['lien'])
        $import->importLien($data['lien']);
     }

     return $this->render('admin/import/import_home.html.twig', ['form' => $form->createView()]);
   }
}
