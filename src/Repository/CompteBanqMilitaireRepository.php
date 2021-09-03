<?php

namespace App\Repository;

use App\Entity\CompteBanqMilitaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompteBanqMilitaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompteBanqMilitaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompteBanqMilitaire[]    findAll()
 * @method CompteBanqMilitaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompteBanqMilitaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompteBanqMilitaire::class);
    }

    // /**
    //  * @return CompteBanqMilitaire[] Returns an array of CompteBanqMilitaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompteBanqMilitaire
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
