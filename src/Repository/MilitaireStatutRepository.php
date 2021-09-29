<?php

namespace App\Repository;

use App\Entity\MilitaireStatut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MilitaireStatut|null find($id, $lockMode = null, $lockVersion = null)
 * @method MilitaireStatut|null findOneBy(array $criteria, array $orderBy = null)
 * @method MilitaireStatut[]    findAll()
 * @method MilitaireStatut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MilitaireStatutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MilitaireStatut::class);
    }

    // /**
    //  * @return MilitaireStatut[] Returns an array of MilitaireStatut objects
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


    public function getMilitaireStatut($militaire): ?MilitaireStatut
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.militaire = :militaire')
            ->orderBy("s.id", "DESC")
            ->setParameter('militaire', $militaire)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
        ;
    }

}
