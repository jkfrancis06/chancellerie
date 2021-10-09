<?php

namespace App\Repository;

use App\Entity\Affectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Affectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affectation[]    findAll()
 * @method Affectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affectation::class);
    }

    // /**
    //  * @return Affectation[] Returns an array of Affectation objects
    //  */





    public function findAffectationByUnite($unite)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.unite IN (:unites)')
            ->setParameter('unites', $unite)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
     * Trouver les affectations actives dans une unite
     */
    public function findAffectationByUniteActive($unite)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.unite IN (:unites)')
            ->andWhere('a.isActive = :active)')
            ->setParameter('unites', $unite)
            ->setParameter('active', true)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
     * Trouver les affectations a une date precise dans certaines unites
     */
    public function findSelectedAffectations($unite,$date)
    {

        /*
         *
	unite_id = 4 and
	(
		(affectation.date_debut >= '1975-06-01' and affectation.date_fin = null )
		OR
		( '1975-06-01' between affectation.date_debut and affectation.date_fin  )
	)
         */
        $qb = $this->createQueryBuilder('a');

        $qb->andWhere('a.unite IN (:unites)');
        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->andX("a.dateDebut <= :date","a.dateFin IS NULL"),
                $qb->expr()->andX(":date BETWEEN a.dateDebut AND a.dateFin ")
            )
        );

        $qb->setParameter('unites', $unite);
        $qb->setParameter('date', $date->format('Y-m-d'));


        return $qb ->getQuery()->getResult();
    }


    public function findActiveAff($militaire)
    {
        return $this
            ->createQueryBuilder("e")
            ->where('e.militaire = :val')
            ->andWhere('e.isActive = :active')
            ->orderBy("e.id", "DESC")
            ->setParameter('val',$militaire)
            ->setParameter('active',true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function findLastInserted($militaire)
    {
        return $this
            ->createQueryBuilder("e")
            ->where('e.militaire = :val')
            ->orderBy("e.id", "DESC")
            ->setParameter('val',$militaire)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

}
