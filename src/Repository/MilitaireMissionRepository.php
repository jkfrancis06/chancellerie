<?php

namespace App\Repository;

use App\Entity\MilitaireMission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireMission[]    findAll()
 * @method MilitaireMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireMission::class);
    }

    // /**
    //  * @return MilitaireMission[] Returns an array of MilitaireMission objects
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
    public function findOneBySomeField($value): ?MilitaireMission
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
