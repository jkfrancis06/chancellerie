<?php

namespace App\Repository;

use App\Entity\Militaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Militaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Militaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Militaire[]    findAll()
 * @method Militaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Militaire::class);
    }

    // /**
    //  * @return Militaire[] Returns an array of Militaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function searchMilitaire($form)
    {
        $qb =  $this->createQueryBuilder('m');

        // matricule
        $matricule = $form->get('matricule')->getData();
        if ($matricule != null){
            $qb->andWhere("m.matricule  LIKE '%$matricule%'");
        }

        // nom
        $nom = $form->get('nom')->getData();
        if ($nom != null){
            $qb->andWhere("m.nom LIKE '%$nom%'");
        }

        // prenom
        $prenom = $form->get('prenoms')->getData();
        if ($nom != null){
            $qb->andWhere("m.prenoms LIKE '%$prenom%'");
        }


        $ddnqr = false;

        // date de naissance
        $ddnarray = $form->get('dateNaissance')->getData();
        if ($ddnarray != null){
            $dates = explode("-", $ddnarray);
            //echo $dates[0]; // piece1
            //echo $dates[1]; // piece2
            if ($this->isValidateDate(trim($dates[0])) && $this->isValidateDate(trim($dates[1]))) {   // if date is valid
                $qb->andWhere("m.dateNaissance BETWEEN :startddn AND :endddn");
                $ddnqr = true;
                $qb->setParameter('startddn', trim($dates[0]));
                $qb->setParameter('endddn', trim($dates[1]));
            }

        }

        // sexe
        $sexe = $form->get('sexe')->getData();
        if ($sexe != null){
            $qb->andWhere("m.sexe = :sexe");
            $qb->setParameter('sexe', $sexe);
        }


        // taille
        $taillearray = $form->get('taille')->getData();
        if ($taillearray != null){
            $tailles = explode("-", $taillearray);
            $qb->andWhere("m.taille BETWEEN :starttaille AND :endtaille");
            $qb->setParameter('starttaille', floatval($tailles[0]));
            $qb->setParameter('endtaille', floatval($tailles[1]));
        }


        // yeux
        $yeux = $form->get('couleurYeux')->getData();
        if ($yeux != null){
            $qb->andWhere("m.couleurYeux = :yeux");
            $qb->setParameter('yeux', $yeux);
        }


        // situationMatrimoniale
        $situationMatrimoniale = $form->get('situationMatri')->getData();
        if ($situationMatrimoniale != null){
            $qb->andWhere("m.situationMatri = :sitMatri");
            $qb->setParameter('sitMatri', $situationMatrimoniale);
        }


        // hasChildren
        $hasChildren = $form->get('hasChildren')->getData();
        if ($hasChildren != null){
            $qb->andWhere("m.hasChildren = :hasChildren");
            $qb->setParameter('hasChildren', $hasChildren);
        }


        // adresse
        $adresse = $form->get('adresse')->getData();
        if ($adresse != null){
            $qb->andWhere("m.adresse = :adresse");
            $qb->setParameter('adresse', $adresse);
        }


        // telephone
        $telephone = $form->get('telephone')->getData();
        if ($telephone != null){
            $telephones = explode(";",$telephone);
            $qb->leftJoin('m.telephone', 'telephone');
            $qb->andWhere($qb->expr()->in('telephone.numero', ':telephones'));
            $qb->setParameter('telephones', $telephones);
        }


        // date de incorp
        $dateIncorparray = $form->get('dateIncorp')->getData();
        if ($dateIncorparray != null){
            $dates = explode("-", $dateIncorparray);
            if ($this->isValidateDate(trim($dates[0])) && $this->isValidateDate(trim($dates[1]))) {   // if date is valid
                $qb->andWhere("m.dateIncorp BETWEEN :startddn AND :endddn");
                $qb->setParameter('startddn', trim($dates[0]));
                $qb->setParameter('endddn', trim($dates[1]));
            }

        }


        // professionAnt
        $professionAnt = $form->get('professionAnt')->getData();
        if ($professionAnt != null){
            $qb->andWhere("m.professionAnt LIKE '%$professionAnt%'");
        }


        // grade
        $grade = $form->get('grade')->getData();
        if (sizeof($grade) > 0){
            $qb->andWhere($qb->expr()->in('m.grade', ':grade'));
            $qb->setParameter('grade', $grade);
        }


        // specialite
        $specialite = $form->get('specialite')->getData();
        if (sizeof($specialite) > 0){
            $qb->andWhere( $qb->expr()->in('m.specialite', ':specialite'));
            $qb->setParameter('specialite', $specialite);
        }

        // origineRecrutement
        $origineRecrutement = $form->get('origineRecrutement')->getData();
        if (sizeof($specialite) > 0){
            $qb->andWhere($qb->expr()->in('m.origineRecrutement', ':origineRecrutement'));
            $qb->setParameter('origineRecrutement', $origineRecrutement);
        }



        return $qb->getQuery()->getResult();




    }



    function isValidateDate($date, $format = 'd-m-Y')
    {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

}
