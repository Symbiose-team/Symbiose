<?php

namespace App\Repository;

use App\Entity\SpecialEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SpecialEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SpecialEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpecialEvent[]    findAll()
 * @method SpecialEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SpecialEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpecialEvent::class);
    }

    // /**
    //  * @return SpecialEvent[] Returns an array of SpecialEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SpecialEvent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
