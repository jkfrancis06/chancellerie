<?php

namespace App\Repository;

use App\Entity\MilitaireDiplome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireDiplome|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireDiplome|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireDiplome[]    findAll()
 * @method MilitaireDiplome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireDiplomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireDiplome::class);
    }

    // /**
    //  * @return MilitaireDiplome[] Returns an array of MilitaireDiplome objects
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
    public function findOneBySomeField($value): ?MilitaireDiplome
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
