<?php

namespace AppBundle\Form;

use AppBundle\Entity\DemandeEmbauche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\HttpFoundation\Session\Session;

class DemandeEmbaucheType extends AbstractType
{
  private $session;


  public function __construct(Session $session)
  {
    $this->session = $session;
  }

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    switch ($options['step']) {

    // Etape 1
    case '1':

      $builder
        ->add('nom', null, array('attr' => ['class' => 'form-control']))
        ->add('prenom', null, array('attr' => ['class' => 'form-control']))
        ->add('sexe', ChoiceType::class, array(
          'choices'  => array(
            'embauche.sexe.m'  => 'embauche.sexe.m',
            'embauche.sexe.f' => 'embauche.sexe.f',
          ),
          'choice_translation_domain' => 'embauche',
          'translation_domain' => 'embauche',
          'expanded' => true,
          'multiple' => false,
        ))
        ->add('addresse1', null, array('attr' => ['class' => 'form-control']))
        ->add('addresse2', null, array('attr' => ['class' => 'form-control']))
        ->add('codePostal', null, array('attr' => ['class' => 'form-control']))
        ->add('ville', null, array('attr' => ['class' => 'form-control']))
        ->add('telephone', TextType::class, array('attr' => ['class' => 'form-control']))
        ->add('email', EmailType::class, array('attr' => ['class' => 'form-control']))
        ->add('numSecu', TextType::class, array('attr' => ['class' => 'form-control',
              'placeholder' => '_  _ _  _ _  _ _  _ _ _  _ _ _  _ _']))
        ->add('dateNaissance', DateType::class, array(
          'widget' => 'choice',
          'format' => 'd/M/y',
          'years' => range(date('Y') - 100, date('Y') - 20),
          'attr' => ['class' => '']))
        ->add('nationalite', ChoiceType::class, array(
            'choices'  => array(
              'embauche.nat.fr'  => 'embauche.nat.fr',
              'embauche.nat.etr' => 'embauche.nat.etr',
            ),
            'translation_domain' => 'embauche',
            'choice_translation_domain' => 'embauche',
            'expanded' => true,
            'multiple' => false,
          ))
          ->add('nbEnfant', null, array('attr' => ['class' => 'form-control'], 'data' => 0))
          ->add('situationFamille', ChoiceType::class, array(
            'choices'  => array(
              'embauche.fam.celib' => 'embauche.fam.celib',
              'embauche.fam.marie' => 'embauche.fam.marie',
              'embauche.fam.pacse' => 'embauche.fam.pacse',
              'embauche.fam.conc'  => 'embauche.fam.conc',
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'attr' => ['class' => 'form-control']
          ))
          ->add('villeNaissance', null, array('attr' => ['class' => 'form-control']))
          ->add('paysNaissance', null, array('attr' => ['class' => 'form-control']))
          ->add('Envoyer', SubmitType::class, array(
            'label' => 'embauche.step1',
            'attr' => array('class' => 'btn-black end'),
            'translation_domain' => 'embauche',
          ))

          ->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event)
            {
              $form = $event->getForm();
              $data = $event->getData();

              $test = $this->session->get('nat');

              if (isset($data["nationalite"]) && $data["nationalite"] == "nationalite")
              {
                $form->add('autre_nationalite', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'label' => 'embauche.autre',
                    'translation_domain' => 'embauche',
                    'mapped' => false,
                    'empty_data' => $test
                  ));
              }
                $event->setData($data);
            })

            // Quand le formulaire est posté
            // si nationalite - autre coché et remplie
            // alors on met la variable dans nationalité
            ->addEventListener(
              FormEvents::SUBMIT,
              function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                $extra = $form->getExtraData();

                dump($extra, $data);
                if (!($data instanceof DemandeEmbauche))
                  return;

                if (isset($extra['autre_nationalite'])) {
                  $this->session->set('nat',  $extra['autre_nationalite']);
                }

                $event->setData($data);
              });

    break;

    // Etape 2
    case '2':

      $builder
          ->add('dateembauche', DateType::class, array(
            'widget' => 'choice',
            'format' => 'd/M/y',
            'years' => range(date('Y') - 80, date('Y') + 2),
            'attr' => ['class' => '']
          ))
          ->add('dejaSalarie', ChoiceType::class,array(
            'choices' => array(
              'embauche.ancien.oui' => 'true',
              'embauche.ancien.no' => 'false'
            ),
            'expanded' => true,
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'multiple' => false,
          ))
          ->add('postes', ChoiceType::class, array(
            'choices' => array(
              'embauche.poste.coif' => 'embauche.poste.coif',
              'embauche.poste.tech' => 'embauche.poste.tech',
              'embauche.autre'      => 'embauche.autre'
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'expanded' => true,
            'multiple' => false,
          ))
          ->add('diplomes', ChoiceType::class,array(
            'choices' => array(
              'embauche.diplome.CAP' => 'embauche.diplome.CAP',
              'embauche.diplome.BEP' => 'embauche.diplome.BEP',
              'embauche.autre'=> 'embauche.autre'
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'expanded' => true,
            'multiple' => true,
          ))
          ->add('niveau', ChoiceType::class, array(
            'choices' => array(
              'I' => 'I',
              'II' => 'II',
              'III'=> 'III',
              'IV' => 'IV',
              'V' => 'V'
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'attr' => ['class' => 'form-control']
          ))
          ->add('echelon', ChoiceType::class, array(
            'choices' => array(
              '1' => '1',
              '2' => '2',
              '3'=> '3'
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'attr' => ['class' => 'form-control']
          ))
          ->add('autre', TextType::class, array(
            'required'   => false,
            'label' => 'embauche.autre',
            'translation_domain' => 'embauche',
            'attr' => ['class' => 'form-control']
          ))
          ->add('salaireBase', null, array('attr' => ['class' => 'form-control']))
          ->add('typeContrat', ChoiceType::class, array(
            'choices' => array(
              'embauche.cdi'  => 'embauche.cdi',
              'embauche.appr' => 'embauche.appr',
              'embauche.pro' => 'embauche.pro',
              'embauche.cdd'  => 'embauche.cdd'
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'expanded' => true,
            'multiple' => false,
          ))
          ->add('cddRaison', ChoiceType::class, array(
            'choices' => array(
              'embauche.cdd.surcroit'  => 'embauche.cdd.surcroit',
              'embauche.cdd.rempla' => 'embauche.cdd.rempla',
              'embauche.cdd.renouv' => 'embauche.cdd.renouv',
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'expanded' => true,
            'multiple' => false,
          ))
          ->add('remplacementNom', null, array('attr' => ['class' => 'form-control']))
          ->add('remplacementNature', null, array('attr' => ['class' => 'form-control']))
          ->add('precisionDate', ChoiceType::class,array(
            'choices' => array(
              'embauche.precision.p' => 'embauche.precision.p',
              'embauche.precision.i' => 'embauche.precision.i'
            ),
            'expanded' => true,
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'multiple' => false,
          ))
          ->add('isTempsPartiel', ChoiceType::class,array(
            'choices' => array(
              'embauche.ancien.oui' => 'true',
              'embauche.ancien.no' => 'false'
            ),
            'expanded' => true,
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'multiple' => false,
          ))
          ->add('Envoyer', SubmitType::class, array(
            'label' => 'embauche.step2',
            'attr' => array('class' =>'btn-black end'),
            'translation_domain' => 'embauche',
          ));

          $builder->add('date', DateType::class, array(
            'widget' => 'choice',
            'format' => 'd/M/y',
            'years' => range(date('Y') - 5, date('Y') + 10),
            'attr' => ['class' => 'until'],
            'label' => ' ',
            'mapped' => false,
            'data' => $this->session->get('date')
          ))
          ->add('tempsPartiel', CollectionType::class,[
          'entry_type' => NumberType::class,'translation_domain' => 'embauche'])

          // Foncionne avec l'ajax. Si champs autre coché alors
          // le champ correspondant est ajouté et renvoyé
          ->addEventListener(
            FormEvents::PRE_SUBMIT,
            function(FormEvent $event)
            {
              $form = $event->getForm();
              $data = $event->getData();

              $demande = $this->session->get('demande');
              $value = '';

              if (isset($data['lieu']))
              {
                if ($demande)
                  $value = $demande->getSalarieLieu();

                  $form->add('autre_lieu', TextType::class, array(
                    'attr' => array('class' => 'form-control'),
                    'mapped' => false,
                    'label' => 'embauche.lieu',
                    'translation_domain' => 'embauche',
                    'empty_data' => $value
                  ));
              }

              else if (isset($data["diplome"]) && $data["diplome"] == "diplome")
              {
                $test = $this->session->get('diplome');

                $form->add('autre_diplome', TextType::class, array(
                  'attr' => array('class' => 'form-control'),
                  'mapped' => false,
                  'label' => 'embauche.autre',
                  'translation_domain' => 'embauche',
                  'empty_data' => $test
                ));
              }

              else if (isset($data["poste"]) && $data["poste"] == "poste")
              {

                $test = $this->session->get('poste');

                $form->add('autre_poste', TextType::class, array(
                  'attr' => array('class' => 'form-control'),
                  'mapped' => false,
                  'label' => 'embauche.autre',
                  'translation_domain' => 'embauche',
                  'empty_data' => $test
                ));
              }
              dump($data,  $form, $form->get('date')->getData());
              $event->setData($data);
            })

        // Gestion des champs extras après envoie de l'étape 2
        ->addEventListener(
          FormEvents::SUBMIT,
          function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $extra = $form->getExtraData();

            if (!($data instanceof DemandeEmbauche))
            return;

            if ($data->getDejaSalarie() == true && isset($extra['autre_lieu']))
              $data->setSalarieLieu($extra['autre_lieu']);

            // if ($data->getPostes() == 'embauche.autre')
            //   $data->setPostes($extra['autre_poste']);


           //  if (in_array($data->getDiplomes(), 'embauche.autre')) {
           //    if (isset($extra['autre_diplome'])) {
           //      $array = $data->getDiplomes();
           //      $array[] = $this->session->get('diplome');
           //      $data->setDiplomes(json_encode($array));
           //     }
           // }

            // Si le champ "autre" de la classification ( c.à.d niveau et échelon) non null
            // alors rendre null ces champs
            if ($data->getAutre() != '' || $data->getAutre() != null)
            {
              $data->setAutre($data->getAutre());
              $data->setEchelon(null);
              $data->setNiveau(null);
            }

            if (isset($extra['autre_poste'])){
              $test = $extra['autre_poste'];
              $this->session->set('poste', $test);
            }

            if (isset($extra['autre_diplome'])){
              $test = $extra['autre_diplome'];
              $this->session->set('diplome', $test);
            }
            // Traitement si contrat = CDD
            // Recupère les champs extras:
            // raison, jusqu'au, nature, nom

            //dump($data, $extra, $form, $form->get('date')->getData() );

            if($data->getTypeContrat() == 'embauche.cdd')
            {
              if ($form->get('date')->getData() != null)
                $data->setCddDate($form->get('date')->getData());
                $this->session->set('date', $form->get('date')->getData());
                //$data->setCddRaison($data->getCddRaison());
            //
            //   if (isset($extra['raison']['absence']))
            //     $data->setRemplacementNature($extra['raison']['absence']);
            //
            //   if ($form->get('date')->getData() != null)
            //     $data->setCddDate($form->get('date')->getData());
            //
            //   if (isset($extra['raison']['nom']))
            //     $data->setRemplacementNom($extra['raison']['nom']);
            //
            //   if (isset($extra['raison']['retour']))
            //   {
            //     $data->setCddRetour($extra['raison']['retour']);
            //     $data->setCddDate(null);
            //   }
            }

            // Récupération des temps partiels
            // if (isset($extra['tempsPartiel']))
            //   $data->setTempsPartiel($extra['tempsPartiel']);

            $event->setData($data);
          });
     break;

    case '3':

      $builder
        ->add('carteId', FileType::class)
        ->add('carteVitale', FileType::class)
        ->add('diplomeFile', FileType::class)
        ->add('diplomeFile2', FileType::class)
        ->add('rib', FileType::class)
        ->add('mutuelle', FileType::class)
        ->add('Envoyer', SubmitType::class, array(
          'label' => 'embauche.send',
          'attr' => array('class' =>'btn-black end'),
          'translation_domain' => 'embauche',
        ))
        ->addEventListener(FormEvents::SUBMIT,
            function (FormEvent $event) {
              $form = $event->getForm();
              $data = $event->getData();

              if ($data->getPostes() == 'embauche.autre')
                $data->setPostes($this->session->get('poste'));

               if (in_array('embauche.autre', $data->getDiplomes())) {
                 $array = $data->getDiplomes();
                 $array[2] = $this->session->get('diplome');
                 $data->setDiplomes($array);
                }


              // if($data->getTypeContrat() == 'embauche.cdd')
              // {
              //   $data->setCddRaison($extra['raison']['raison']);
              //
              //   if (isset($extra['raison']['absence']))
              //     $data->setRemplacementNature($extra['raison']['absence']);
              //
              //   if ($form->get('date')->getData() != null)
              //     $data->setCddDate($form->get('date')->getData());
              //
              //   if (isset($extra['raison']['nom']))
              //     $data->setRemplacementNom($extra['raison']['nom']);
              //
              //   if (isset($extra['raison']['retour'])) {
              //     $data->setCddRetour($extra['raison']['retour']);
              //     $data->setCddDate(null);
              //   }
              // }
        });
      break;
    case '4':

        $builder
        ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
          $demande = $event->getData();
          $form = $event->getForm();

          $form
          ->add('nom', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('prenom', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('addresse1', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('addresse2', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('codePostal', NumberType::class, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('ville', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('telephone', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('email', EmailType::class, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('numSecu', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('dateNaissance', DateType::class, array(
                                          'widget' => 'single_text',
                                          'html5' => false,
                                          'format' => 'd/M/y',
                                          'attr' => ['class' => 'js-datepicker form-control', 'readonly' => true]))
          ->add('villeNaissance', TextType::class, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('paysNaissance', TextType::class, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('nationalite', ChoiceType::class, array(
            'choices'  => array(
              'embauche.nat.fr'  => 'embauche.nat.fr',
              'embauche.nat.etr' => 'embauche.nat.etr',
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'translation_domain' => 'embauche',
            'choice_translation_domain' => 'embauche',
          ))
          ->add('sexe', ChoiceType::class, array(
            'choices'  => array(
              'embauche.sexe.m'  => 'embauche.sexe.m',
              'embauche.sexe.f' => 'embauche.sexe.f',
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'translation_domain' => 'embauche',
            'choice_translation_domain' => 'embauche',
          ))
          ->add('nbEnfant', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('situationFamille', ChoiceType::class, array(
            'choices'  => array(
              'embauche.fam.marie' => 'embauche.fam.marie',
              'embauche.fam.pacse' => 'embauche.fam.pacse',
              'embauche.fam.conc'  => 'embauche.fam.conc',
              'embauche.fam.celib' => 'embauche.fam.celib',
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'choice_translation_domain' => 'embauche',
          ))
          ->add('villeNaissance', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('dateembauche', DateType::class, array(
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'd/M/y',
            'attr' => ['class' => 'js-datepicker form-control', 'readonly' => true]
          ))
          ->add('dejaSalarie', ChoiceType::class, array(
            'choices' => array(
              'embauche.ancien.oui' => 'true',
              'embauche.ancien.no' => 'false'
            ),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
            'multiple' => false,
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
          ));
          if ($demande->getDejaSalarie() == 'embauche.ancien.no')
          {
            $form->add("salarieLieu", TextType::class, array(
              'attr' => array('readonly' => true)
            ));
          }

          if ($demande->getPostes() == "embauche.poste.coif"
          || $demande->getPostes() == "embauche.poste.tech")
          {
            $form->add('postes', ChoiceType::class, array(
              'choices' => array(
                'embauche.poste.coif' => 'embauche.poste.coif',
                'embauche.poste.tech' => 'embauche.poste.tech',
                'embauche.autre'      => 'embauche.autre'
              ),
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
              'choice_translation_domain' => 'embauche',
              'translation_domain' => 'embauche',
            ));
          }
          else
            $form->add('postes', TextType::class, array('attr'=>['readonly' => true]));

          // if ($demande->getDiplomes() == "embauche.autre")
          // {
          //   $form->add('postes', TextType::class, array('attr'=>['readonly' => true]));
          // }
          // else
          // {
            $form->add('diplomes', null, array(
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
              'translation_domain' => 'embauche',
            ));
            // ->add('diplomes', ChoiceType::class,array(
            //   'choices' => array(
            //     'embauche.diplome.CAP' => 'embauche.diplome.CAP',
            //     'embauche.diplome.BEP' => 'embauche.diplome.BEP',
            //     'embauche.autre'=> 'embauche.autre'
            //   ),
            //   'attr' => array('readonly' => true,
            //   'disabled' => true,
            //   'class' =>'onlyread form-control'),
            //   'choice_translation_domain' => 'embauche',
            //   'translation_domain' => 'embauche',
            // ));
          // }
          if($demande->getAutre() != null || $demande->getAutre() != "")
          {
            $form->add('autre', TextType::class, array(
              'required'   => false,
              'label' => 'embauche.autre',
              'translation_domain' => 'embauche',
              'attr' => ['class' => 'form-control', 'readonly' => true]
            ));
          }
          else
          {
            $form
            ->add('niveau', ChoiceType::class, array(
              'choices' => array(
                'I'   => 'I',
                'II'  => 'II',
                'III' => 'III',
                'IV'  => 'IV',
                'V'   => 'V'
              ),
              'choice_translation_domain' => 'embauche',
              'translation_domain' => 'embauche',
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
            ))
            ->add('echelon', ChoiceType::class, array(
              'choices' => array(
                '1' => '1',
                '2' => '2',
                '3' => '3'
              ),
              'choice_translation_domain' => 'embauche',
              'translation_domain' => 'embauche',
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
            ));

          }
            $form->add('salaireBase', NumberType::class,array(
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
              'translation_domain' => 'embauche',
            ));

          $form
          ->add('typeContrat', ChoiceType::class,array(
            'choices' => array(
              'embauche.cdi'  => 'embauche.cdi',
              'embauche.appr' => 'embauche.appr',
              'embauche.pro' => 'embauche.pro',
              'embauche.cdd'  => 'embauche.cdd'
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'choice_translation_domain' => 'embauche',
            'translation_domain' => 'embauche',
          ));
          if ($demande->getTypeContrat() == 'embauche.cdd')
          {
            $form
            ->add('cddRaison', ChoiceType::class, array(
              'choices' => array(
                'embauche.cdd.rempla'  => 'embauche.cdd.rempla'
              ),
              'required'   => false,
              'label' => 'embauche.cdd.retour',
              'choice_translation_domain' => 'embauche',
              'translation_domain' => 'embauche',
              'attr' => ['readonly' => true,'disabled' => true]
            ))

            ->add('remplacementNature', null, array('attr' => array('readonly' => true)));

            if ($demande->getCddDate() != null)
              $form->add('cddDate',DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'd/M/y',
                'attr' => ['class' => 'js-datepicker form-control', 'readonly' => true]));
              else
                $form->add('cddRetour', ChoiceType::class, array(
                  'choices' => array(
                    'embauche.cdd.retour'  => 'embauche.cdi',
                  ),
                  'required'   => false,
                  'label' => 'embauche.cdd.retour',
                  'choice_translation_domain' => 'embauche',
                  'translation_domain' => 'embauche',
                  'attr' => ['class' => 'form-control', 'readonly' => true]
                ));

              $form
                  ->add('remplacementNom', null, array('attr' => array('readonly' => true)));
            }

            $form
                ->add('tempsPartiel', null, array('attr' => array('readonly' => true)))
                ->add('carteId', TextType::class, array('attr' => ['class' => 'getDocument', 'readonly' => true]))
                ->add('carteVitale', TextType::class, array('attr' => ['class' => 'getDocument', 'readonly' => true]))
                ->add('diplomeFile', TextType::class, array('attr' => ['class' => 'getDocument', 'readonly' => true]))
                ->add('rib', TextType::class, array('attr' => ['class' => 'getDocument', 'readonly' => true]))
                ->add('mutuelle', TextType::class, array('attr' => ['class' => 'getDocument', 'readonly' => true]));
          }
        );
       break;
     }
   }

    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => DemandeEmbauche::class,
        'allow_extra_fields' => true,
        'step' => null
      ));
    }
  }
