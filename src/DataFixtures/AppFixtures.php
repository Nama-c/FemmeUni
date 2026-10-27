<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Epargne;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\Participation;
use App\Entity\Pret;
use App\Entity\Tontine;
use App\Entity\Versement;
use App\Enum\Fonction;
use App\Enum\StatutPret;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Groupement
        $groupement = new Groupement();
        $groupement->setNom('Femme Unie Dakar');
        $groupement->setAdresse('Dakar, Sénégal');
        $groupement->setTel('770000000');
        $manager->persist($groupement);

        // 2. Admin
        $admin = new Admin();
        $admin->setNomComplet('Awa Diop');
        $admin->setTel('771111111');
        $admin->setAdresse('Dakar');
        $admin->setLogin('admin');
        $admin->setPassword($this->hasher->hashPassword($admin, 'admin123'));
        $admin->setFonction(Fonction::CHEF);
        $admin->setGroupement($groupement);
        $manager->persist($admin);

        // 3. Membres
        $donnees = [
            ['Fatou Sow', 'fatou', Fonction::TRESORIER],
            ['Aminata Ndiaye', 'aminata', Fonction::SECRETAIRE],
            ['Khady Fall', 'khady', null],
            ['Mariama Ba', 'mariama', null],
        ];

        $membres = [];
        foreach ($donnees as $i => [$nom, $login, $fonction]) {
            $membre = new Membre();
            $membre->setNomComplet($nom);
            $membre->setTel('77222222' . $i);
            $membre->setAdresse('Dakar');
            $membre->setLogin($login);
            $membre->setPassword($this->hasher->hashPassword($membre, 'membre123'));
            $membre->setFonction($fonction);
            $membre->setActif(true);
            $membre->setGroupement($groupement);
            $manager->persist($membre);
            $membres[] = $membre;
        }

        // 4. Campagnes
        $tontine = new Tontine();
        $tontine->setNom('Tontine mensuelle');
        $tontine->setDateDebut(new \DateTimeImmutable('2026-11-01'));
        $tontine->setMontant(10000);
        $tontine->setPeriode(30);
        $tontine->setNbTour(5);
        $tontine->setGroupement($groupement);
        $manager->persist($tontine);

        $epargneFixe = new Epargne();
        $epargneFixe->setNom('Épargne projet');
        $epargneFixe->setDateDebut(new \DateTimeImmutable('2026-11-01'));
        $epargneFixe->setMontant(5000);
        $epargneFixe->setObjectif(100000);
        $epargneFixe->setLibre(false);
        $epargneFixe->setGroupement($groupement);
        $manager->persist($epargneFixe);

        $epargneLibre = new Epargne();
        $epargneLibre->setNom('Coffre libre');
        $epargneLibre->setDateDebut(new \DateTimeImmutable('2026-11-01'));
        $epargneLibre->setLibre(true);
        $epargneLibre->setGroupement($groupement);
        $manager->persist($epargneLibre);

        // 5. Participations : tout le monde dans la tontine,
        //    les deux premiers membres dans les épargnes
        $tous = array_merge([$admin], $membres);
        foreach ($tous as $user) {
            $p = new Participation();
            $p->setUtilisateur($user);
            $p->setCampagne($tontine);
            $manager->persist($p);
        }

        foreach (array_slice($membres, 0, 2) as $user) {
            foreach ([$epargneFixe, $epargneLibre] as $campagne) {
                $p = new Participation();
                $p->setUtilisateur($user);
                $p->setCampagne($campagne);
                $manager->persist($p);
            }
        }

        // 6. Versements
        foreach ($tous as $user) {
            $v = new Versement();
            $v->setUtilisateur($user);
            $v->setCampagne($tontine);
            $v->setMontant(10000);
            $manager->persist($v);
        }

        $v = new Versement();
        $v->setUtilisateur($membres[0]);
        $v->setCampagne($epargneFixe);
        $v->setMontant(5000);
        $manager->persist($v);

        $v = new Versement();
        $v->setUtilisateur($membres[1]);
        $v->setCampagne($epargneLibre);
        $v->setMontant(3200);
        $manager->persist($v);

        // 7. Prêts : un en attente, un approuvé par l'admin
        $pretEnAttente = new Pret();
        $pretEnAttente->setEmprunteur($membres[2]);
        $pretEnAttente->setMontant(50000);
        $manager->persist($pretEnAttente);

        $pretApprouve = new Pret();
        $pretApprouve->setEmprunteur($membres[3]);
        $pretApprouve->setMontant(30000);
        $pretApprouve->setStatut(StatutPret::APPROUVE);
        $pretApprouve->setTraitePar($admin);
        $pretApprouve->setDateEcheance(new \DateTimeImmutable('2027-02-01'));
        $manager->persist($pretApprouve);

        $manager->flush();
    }
}