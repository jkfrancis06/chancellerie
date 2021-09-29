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




    /*
    public function findOneBySomeField($value): ?Affectation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

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
