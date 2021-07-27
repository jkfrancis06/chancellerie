<?php

namespace App\Repository;

use App\Entity\OrigineRecrutement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrigineRecrutement|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrigineRecrutement|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrigineRecrutement[]    findAll()
 * @method OrigineRecrutement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrigineRecrutementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrigineRecrutement::class);
    }

    // /**
    //  * @return OrigineRecrutement[] Returns an array of OrigineRecrutement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrigineRecrutement
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
