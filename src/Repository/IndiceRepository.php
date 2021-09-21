<?php

namespace App\Repository;

use App\Entity\Indice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Indice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Indice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Indice[]    findAll()
 * @method Indice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Indice::class);
    }

    // /**
    //  * @return Indice[] Returns an array of Indice objects
    //  */

    public function findIncides($grades)
    {
       $qb =  $this->createQueryBuilder('e');
            $qb->leftJoin('e.grade', 'telephone');
            $qb->andWhere($qb->expr()->in('telephone.numero', ':telephones'));
            $qb->setParameter('category', $category);
            $qb->orderBy('e.name', 'ASC');
            return $qb->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Indice
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
