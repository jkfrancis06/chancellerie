<?php

namespace App\Repository;

use App\Entity\PersonnePrev;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonnePrev|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonnePrev|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonnePrev[]    findAll()
 * @method PersonnePrev[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnePrevRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonnePrev::class);
    }

    // /**
    //  * @return PersonnePrev[] Returns an array of PersonnePrev objects
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
    public function findOneBySomeField($value): ?PersonnePrev
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
