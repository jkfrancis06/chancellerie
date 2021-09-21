<?php

namespace App\Repository;

use App\Entity\MilitaireExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireExercice[]    findAll()
 * @method MilitaireExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireExercice::class);
    }

    // /**
    //  * @return MilitaireExercice[] Returns an array of MilitaireExercice objects
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
    public function findOneBySomeField($value): ?MilitaireExercice
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
