<?php

namespace App\Repository;

use App\Entity\MilitaireSpa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireSpa|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireSpa|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireSpa[]    findAll()
 * @method MilitaireSpa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireSpaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireSpa::class);
    }

    // /**
    //  * @return MilitaireSpa[] Returns an array of MilitaireSpa objects
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

    /*
    public function findOneBySomeField($value): ?MilitaireSpa
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
