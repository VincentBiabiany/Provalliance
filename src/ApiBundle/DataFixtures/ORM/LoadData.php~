<?php

namespace ApiBundle\DataFixtures\ORM;

use ApiBundle\Entity\Enseigne;
use ApiBundle\Entity\Profession;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ApiBundle\Entity\Personnel;
use ApiBundle\Entity\Adresse;
use ApiBundle\Entity\Pays;
use ApiBundle\Entity\Salon;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $pays = new Pays();
        $pays->setNom("France");


        /* Création d'un manager */
        $pays2 = new Pays();
        $pays2->setNom("Allemagne");

        $adresse = new Adresse();
        $adresse->setVille("Meudon")->setCp("92100")->setPays($pays);


        $personne = new Personnel();
        $personne->setNom("Bernard")->setPrenom("MINET")->setActif(true)->setAdresse($adresse);

        $profession = new Profession();
        $profession->setNom("manager")->addPersonnel($personne);
        $personne->addProfession($profession);


        /* Création d'un service paie */

        $adresse2 = new Adresse();
        $adresse2->setVille("Clamart")->setCp("92200")->setPays($pays);


        $personne2 = new Personnel();
        $personne2->setNom("Stépahne")->setPrenom("DESCHAMPS")->setActif(true)->setAdresse($adresse2);

        $profession2 = new Profession();
        $profession2->setNom("service paie")->addPersonnel($personne2);
        $personne2->addProfession($profession2);


        /* Création d'un salon */
        $adresse3 = new Adresse();
        $adresse3->setVille("Boulogne")->setCp("92100")->setPays($pays);

        $enseigne = new Enseigne();
        $enseigne->setNom("Frank Provost");

        $salon = new Salon();
        $salon->setNom("Frank Provost")->setNom("BOULOGNE")->setAdresse($adresse3)->setSiret("152464BE6")->setMarlix("3");
        $salon->setSagePaie(57901);
        $salon->setEnseigne($enseigne);

        $manager->persist($pays2);
        $manager->persist($salon);
        $manager->persist($personne);
        $manager->persist($personne2);
        $manager->persist($profession);
        $manager->persist($profession2);
        $manager->flush();
    }
}