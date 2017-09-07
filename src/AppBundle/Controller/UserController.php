<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserController extends Controller
{


      /**
     * @Route("/create", name="user_create")
     */
    public function createAction(Request $request)
    {
         $formFactory = $this->container->get('fos_user.registration.form.factory');

        $form = $formFactory->createForm();

        $form ->add('enabled', ChoiceType::class, array(
                 'choices'  => array('Activer' => 1,'Desactiver' => 0),
                        'expanded' => true,
                        'multiple' => false));
        $form-> add('Valider', SubmitType::class, array(
               'label' => 'Créer un utilisateur',
               'translation_domain' => 'FOSUserBundle',
               'attr' => array(
                     'class' => 'btn btn-primary'
                      )
                     )
                );

         if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                 $task = $form->getData();

                 $em = $this->getDoctrine()->getManager();
                 $em->persist($task);
                 $em->flush();

	            return $this->redirect($this->generateUrl('homepage'));
            }
        }

         return $this->render('@FOSUser/Security/create_user.html.twig',['form' => $form->createView()]);

    }

}
