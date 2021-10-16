<?php

namespace App\Repository;

use App\Entity\MilitaireSpa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireSpa|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireSpa|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireSpa[]    findAll()
 * @method MilitaireSpa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireSpaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireSpa::class);
    }

    // /**
    //  * @return MilitaireSpa[] Returns an array of MilitaireSpa objects
    //  */

    public function findSpaByUnites($selectedDate,$unites)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin("m.spa", "spa")
            ->andWhere('spa.dateSpa = :selectedDate')
            ->andWhere('spa.unite IN (:unites)')
            ->setParameter('selectedDate', $selectedDate)
            ->setParameter('unites', $unites)
            ->orderBy('spa.dateSpa', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }



    public function findLastSpa($militaire): ?MilitaireSpa
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.spa','s')
            ->andWhere('m.militaire = :militaire')
            ->orderBy('s.dateSpa','DESC')
            ->setParameter('militaire', $militaire)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

}
