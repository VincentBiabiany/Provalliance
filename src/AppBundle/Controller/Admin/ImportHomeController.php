<?php
namespace AppBundle\Controller\Admin;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Service\ImportService;

/**
 * @Route("/admin/import", name="importHome")
 */
class ImportHomeController extends Controller
{
   public function indexAction(Request $request, ImportService $import)
   {
     $success = null;
     $form = $this->createFormBuilder()
     ->add('salon', FileType::class, array(
         'required' => false,
         'attr' => ['accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
         'label' => 'import.salon',
         'translation_domain' => 'translator',
      ))
     ->add('personnel', FileType::class, array(
         'required' => false,
         'attr' => ['accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
         'label' => 'import.personnel',
         'translation_domain' => 'translator'
     ))
     ->add('lien', FileType::class, array(
         'required' => false,
         'attr' => ['accept' => '.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'],
         'label' => 'import.lien',
         'translation_domain' => 'translator',
      ))
     ->add('send', SubmitType::class, [
         'label' => 'import.import',
         'attr' => array('class' => 'btn-black end'),
         'translation_domain' => 'translator',
     ])
     ->getForm();

     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()) {
       $data = $form->getData();
       try {
         if($data['salon'])
          $import->importSalon($data['salon']);

         if($data['personnel'])
          $import->importPersonnel($data['personnel']);

         if($data['lien'])
          $import->importLien($data['lien']);
       } catch (\Exception $e) {

         return $this->render('admin/import/import_home.html.twig', [
                                              'form'   => $form->createView(),
                                              'erreur' => $e->getMessage(),
                                              'success'=> null
                                            ]);
       }
       $success = $this->get('translator')->trans('import.sucmsg', [], 'translator');
     }

     return $this->render('admin/import/import_home.html.twig', ['form' => $form->createView(), 'erreur' => null, 'success'=> $success]);
   }
}
