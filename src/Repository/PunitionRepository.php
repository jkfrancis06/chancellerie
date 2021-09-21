<?php

namespace App\Repository;

use App\Entity\Punition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Punition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Punition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Punition[]    findAll()
 * @method Punition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PunitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Punition::class);
    }

    // /**
    //  * @return Punition[] Returns an array of Punition objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Punition
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
