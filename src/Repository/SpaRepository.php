<?php

namespace App\Repository;

use App\Entity\Spa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Spa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Spa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Spa[]    findAll()
 * @method Spa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Spa::class);
    }

    // /**
    //  * @return Spa[] Returns an array of Spa objects
    //  */

    public function findSpaByCorps($unites)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.unite IN (:unites)')
            ->setParameter('unites', $unites)
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findSpaByDateAndUnite($selectedDate,$unites)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.unite IN (:unites)')
            ->andWhere('s.dateSpa  = :dateSpa')
            ->setParameter('unites', $unites)
            ->setParameter('dateSpa', $selectedDate)
            ->orderBy('s.dateSpa', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }



    /*public function findOneBySomeField(): ?Spa
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy("id", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }*/

}
