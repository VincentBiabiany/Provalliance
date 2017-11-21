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
            '___demande_embauche.sexe.m'  => '___demande_embauche.sexe.m',
            '___demande_embauche.sexe.f' => '___demande_embauche.sexe.f',
          ),
          'choice_translation_domain' => 'translator',
          'translation_domain' => 'translator',
          'expanded' => true,
          'multiple' => false,
          'attr' => ['class' => 'form-control'],
        ))
<<<<<<< HEAD
        ->add('adresse1', null, array('attr' => ['class' => 'form-control']))
        ->add('adresse2', null, array('attr' => ['class' => 'form-control']))
        ->add('codePostal', null, array('attr' => ['class' => 'form-control']))
=======
        ->add('addresse1', null, array('attr' => ['class' => 'form-control']))
        ->add('addresse2', null, array('attr' => ['class' => 'form-control']))
        ->add('codePostal', TextType::class, array('attr' => ['class' => 'form-control']))
>>>>>>> dev
        ->add('ville', null, array('attr' => ['class' => 'form-control']))
        ->add('telephone', TextType::class, array('attr' => ['class' => 'form-control']))
        ->add('email', EmailType::class, array('attr' => ['class' => 'form-control']))
        ->add('numSecu', TextType::class, array('attr' => ['class' => 'form-control',
              'placeholder' => '_  _ _  _ _  _ _  _ _ _  _ _ _  _ _']))
        ->add('dateNaissance', DateType::class, array(
          'widget' => 'choice',
          'format' => 'dd/MM/y',
          'years' => range(date('Y') - 100, date('Y') - 20),
          'attr' => ['class' => '']))
        ->add('nationalite', ChoiceType::class, array(
            'choices'  => array(
              '___demande_embauche.nat.fr'  => '___demande_embauche.nat.fr',
              '___demande_embauche.nat.etr' => '___demande_embauche.nat.etr',
            ),
            'translation_domain' => 'translator',
            'choice_translation_domain' => 'translator',
            'expanded' => true,
            'multiple' => false,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('nbEnfant', null, array('attr' => ['class' => 'form-control'], 'data' => 0))
          ->add('situationFamille', ChoiceType::class, array(
            'choices'  => array(
              '___demande_embauche.fam.celib' => '___demande_embauche.fam.celib',
              '___demande_embauche.fam.marie' => '___demande_embauche.fam.marie',
              '___demande_embauche.fam.pacse' => '___demande_embauche.fam.pacse',
              '___demande_embauche.fam.conc'  => '___demande_embauche.fam.conc',
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'attr' => ['class' => 'form-control']
          ))
          ->add('villeNaissance', null, array('attr' => ['class' => 'form-control']))
          ->add('paysNaissance', null, array('attr' => ['class' => 'form-control']))
          ->add('Envoyer', SubmitType::class, array(
            'label' => '___demande_embauche.step1',
            'attr' => array('class' => 'btn-black end'),
            'translation_domain' => 'translator',
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
                    'label' => '___demande_embauche.precisez',
                    'translation_domain' => 'translator',
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
            'format' => 'dd/MM/y',
            'years' => range(date('Y') - 80, date('Y') + 2),
            'attr' => ['class' => ''],
            'data' => new \DateTime()
          ))
          ->add('dejaSalarie', ChoiceType::class,array(
            'choices' => array(
              '___demande_embauche.ancien.oui' => 'true',
              '___demande_embauche.ancien.no' => 'false'
            ),
            'expanded' => true,
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'multiple' => false,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('postes', ChoiceType::class, array(
            'choices' => array(
              '___demande_embauche.poste.coif' => '___demande_embauche.poste.coif',
              '___demande_embauche.poste.tech' => '___demande_embauche.poste.tech',
              '___demande_embauche.autre'      => '___demande_embauche.autre'
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'expanded' => true,
            'multiple' => false,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('diplomes', ChoiceType::class,array(
            'choices' => array(
              '___demande_embauche.diplome.CAP' => '___demande_embauche.diplome.CAP',
              '___demande_embauche.diplome.BEP' => '___demande_embauche.diplome.BEP',
              '___demande_embauche.autre'=> '___demande_embauche.autre'
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'expanded' => true,
            'multiple' => true,
            'required' => true,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('niveau', ChoiceType::class, array(
            'choices' => array(
              'I' => 'I',
              'II' => 'II',
              'III'=> 'III',
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'attr' => ['class' => 'form-control']
          ))
          ->add('echelon', ChoiceType::class, array(
            'choices' => array(
              '1' => '1',
              '2' => '2',
              '3'=> '3'
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'attr' => ['class' => 'form-control']
          ))
          ->add('autre', TextType::class, array(
            'required'   => false,
            'label' => '___demande_embauche.autre',
            'translation_domain' => 'translator',
            'attr' => ['class' => 'form-control']
          ))
          ->add('salaireBase', null, array('attr' => ['class' => 'form-control']))
          ->add('typeContrat', ChoiceType::class, array(
            'choices' => array(
              '___demande_embauche.cdi'  => '___demande_embauche.cdi',
              '___demande_embauche.appr' => '___demande_embauche.appr',
              '___demande_embauche.pro' => '___demande_embauche.pro',
              '___demande_embauche.cdd'  => '___demande_embauche.cdd'
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'expanded' => true,
            'multiple' => false,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('cddRaison', ChoiceType::class, array(
            'choices' => array(
              '___demande_embauche.cdd.surcroit'  => '___demande_embauche.cdd.surcroit',
              '___demande_embauche.cdd.rempla' => '___demande_embauche.cdd.rempla',
              '___demande_embauche.cdd.renouv' => '___demande_embauche.cdd.renouv',
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'expanded' => true,
            'multiple' => false,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('remplacementNom', null, array('attr' => ['class' => 'form-control']))
          ->add('remplacementNature', null, array('attr' => ['class' => 'form-control']))
          ->add('precisionDate', ChoiceType::class,array(
            'choices' => array(
              '___demande_embauche.precision.p' => '___demande_embauche.precision.p',
              '___demande_embauche.precision.i' => '___demande_embauche.precision.i'
            ),
            'expanded' => true,
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'multiple' => false,
          ))
          ->add('isTempsPartiel', ChoiceType::class,array(
            'choices' => array(
              '___demande_embauche.ancien.oui' => 'true',
              '___demande_embauche.ancien.no' => 'false'
            ),
            'expanded' => true,
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'multiple' => false,
            'attr' => ['class' => 'form-control'],
          ))
          ->add('Envoyer', SubmitType::class, array(
            'label' => '___demande_embauche.step2',
            'attr' => array('class' =>'btn-black end'),
            'translation_domain' => 'translator',
          ));

          $builder->add('date', DateType::class, array(
            'widget' => 'choice',
            'format' => 'dd/MM/y',
            'years' => range(date('Y') - 5, date('Y') + 10),
            'attr' => ['class' => 'styleDate'],
            'label' => ' ',
            'mapped' => false,
            'data' => $this->session->get('date')
          ))
          ->add('tempsPartiel', CollectionType::class,[
          'entry_type' => NumberType::class,'translation_domain' => 'translator'])

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
                    'label' => '___demande_embauche.lieu',
                    'translation_domain' => 'translator',
                    'empty_data' => $value
                  ));
              }

              else if (isset($data["diplome"]) && $data["diplome"] == "diplome")
              {
                $test = $this->session->get('diplome');

                $form->add('autre_diplome', TextType::class, array(
                  'attr' => array('class' => 'form-control'),
                  'mapped' => false,
                  'label' => '___demande_embauche.precisez',
                  'translation_domain' => 'translator',
                  'empty_data' => $test
                ));
              }

              else if (isset($data["poste"]) && $data["poste"] == "poste")
              {

                $test = $this->session->get('poste');

                $form->add('autre_poste', TextType::class, array(
                  'attr' => array('class' => 'form-control'),
                  'mapped' => false,
                  'label' => '___demande_embauche.precisez',
                  'translation_domain' => 'translator',
                  'empty_data' => $test
                ));
              }

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


            if($data->getTypeContrat() == '___demande_embauche.cdd')
            {
              if ($form->get('date')->getData() != null) {
                $data->setCddDate($form->get('date')->getData());
                $this->session->set('date', $form->get('date')->getData());
              }


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
        ->add('carteId', FileType::class, array(
          'required' => 'required'
        ))
        ->add('carteVitale', FileType::class, array(
          'required' => 'required'
        ))
        ->add('diplomeFile', FileType::class, array(
          'required' => 'required'
        ))
        ->add('diplomeFile2', FileType::class, array(
          'required' => 'required'
        ))
        ->add('rib', FileType::class, array(
          'required' => 'required'
        ))
        ->add('mutuelle', FileType::class, array(
          'required' => 'required'
        ))
        ->add('Envoyer', SubmitType::class, array(
          'label' => '___demande_embauche.send',
          'attr' => array('class' =>'btn-black end'),
          'translation_domain' => 'translator',
        ))
        ->addEventListener(FormEvents::SUBMIT,
            function (FormEvent $event) {
              $form = $event->getForm();
              $data = $event->getData();

              if ($data->getPostes() == '___demande_embauche.autre')
                $data->setPostes($this->session->get('poste'));

               if (in_array('___demande_embauche.autre', $data->getDiplomes())) {
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
          ->add('adresse1', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('adresse2', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
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
              '___demande_embauche.nat.fr'  => '___demande_embauche.nat.fr',
              '___demande_embauche.nat.etr' => '___demande_embauche.nat.etr',
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'translation_domain' => 'translator',
            'choice_translation_domain' => 'translator',
          ))
          ->add('sexe', ChoiceType::class, array(
            'choices'  => array(
              '___demande_embauche.sexe.m'  => '___demande_embauche.sexe.m',
              '___demande_embauche.sexe.f' => '___demande_embauche.sexe.f',
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'translation_domain' => 'translator',
            'choice_translation_domain' => 'translator',
          ))
          ->add('nbEnfant', null, array('attr' => ['class' => 'form-control', 'readonly' => true]))
          ->add('situationFamille', ChoiceType::class, array(
            'choices'  => array(
              '___demande_embauche.fam.marie' => '___demande_embauche.fam.marie',
              '___demande_embauche.fam.pacse' => '___demande_embauche.fam.pacse',
              '___demande_embauche.fam.conc'  => '___demande_embauche.fam.conc',
              '___demande_embauche.fam.celib' => '___demande_embauche.fam.celib',
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'choice_translation_domain' => 'translator',
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
              '___demande_embauche.ancien.oui' => 'true',
              '___demande_embauche.ancien.no' => 'false'
            ),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
            'multiple' => false,
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
          ));
          if ($demande->getDejaSalarie() == '___demande_embauche.ancien.no')
          {
            $form->add("salarieLieu", TextType::class, array(
              'attr' => array('readonly' => true)
            ));
          }

          if ($demande->getPostes() == "___demande_embauche.poste.coif"
          || $demande->getPostes() == "___demande_embauche.poste.tech")
          {
            $form->add('postes', ChoiceType::class, array(
              'choices' => array(
                '___demande_embauche.poste.coif' => '___demande_embauche.poste.coif',
                '___demande_embauche.poste.tech' => '___demande_embauche.poste.tech',
                '___demande_embauche.autre'      => '___demande_embauche.autre'
              ),
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
              'choice_translation_domain' => 'translator',
              'translation_domain' => 'translator',
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
              'translation_domain' => 'translator',
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
              'label' => '___demande_embauche.autre',
              'translation_domain' => 'translator',
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
              'choice_translation_domain' => 'translator',
              'translation_domain' => 'translator',
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
              'choice_translation_domain' => 'translator',
              'translation_domain' => 'translator',
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
            ));

          }
            $form->add('salaireBase', NumberType::class,array(
              'attr' => array('readonly' => true,
              'disabled' => true,
              'class' =>'onlyread form-control'),
              'translation_domain' => 'translator',
            ));

          $form
          ->add('typeContrat', ChoiceType::class,array(
            'choices' => array(
              '___demande_embauche.cdi'  => '___demande_embauche.cdi',
              '___demande_embauche.appr' => '___demande_embauche.appr',
              '___demande_embauche.pro' => '___demande_embauche.pro',
              '___demande_embauche.cdd'  => '___demande_embauche.cdd'
            ),
            'attr' => array('readonly' => true,
            'disabled' => true,
            'class' =>'onlyread form-control'),
            'choice_translation_domain' => 'translator',
            'translation_domain' => 'translator',
          ));
          if ($demande->getTypeContrat() == '___demande_embauche.cdd')
          {
            $form
            ->add('cddRaison', ChoiceType::class, array(
              'choices' => array(
                '___demande_embauche.cdd.rempla'  => '___demande_embauche.cdd.rempla'
              ),
              'required'   => false,
              'label' => '___demande_embauche.cdd.retour',
              'choice_translation_domain' => 'translator',
              'translation_domain' => 'translator',
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
                    '___demande_embauche.cdd.retour'  => '___demande_embauche.cdi',
                  ),
                  'required'   => false,
                  'label' => '___demande_embauche.cdd.retour',
                  'choice_translation_domain' => 'translator',
                  'translation_domain' => 'translator',
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
