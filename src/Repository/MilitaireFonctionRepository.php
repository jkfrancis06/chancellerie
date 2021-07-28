<?php

namespace App\Repository;

use App\Entity\MilitaireFonction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireFonction|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireFonction|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireFonction[]    findAll()
 * @method MilitaireFonction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireFonctionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireFonction::class);
    }

    // /**
    //  * @return MilitaireFonction[] Returns an array of MilitaireFonction objects
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
    public function findOneBySomeField($value): ?MilitaireFonction
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
