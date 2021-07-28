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

    /*
    public function findOneBySomeField($value): ?Militaire
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
