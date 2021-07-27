<?php

namespace App\Repository;

use App\Entity\GradeCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GradeCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method GradeCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method GradeCategorie[]    findAll()
 * @method GradeCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GradeCategorie::class);
    }

    // /**
    //  * @return GradeCategorie[] Returns an array of GradeCategorie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GradeCategorie
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
