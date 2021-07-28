<?php

namespace App\Repository;

use App\Entity\MilitaireFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireFormation[]    findAll()
 * @method MilitaireFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireFormation::class);
    }

    // /**
    //  * @return MilitaireFormation[] Returns an array of MilitaireFormation objects
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
    public function findOneBySomeField($value): ?MilitaireFormation
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
