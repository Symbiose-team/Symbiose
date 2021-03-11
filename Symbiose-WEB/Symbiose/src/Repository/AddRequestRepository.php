<?php

namespace App\Repository;

use App\Entity\AddRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AddRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method AddRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method AddRequest[]    findAll()
 * @method AddRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AddRequest::class);
    }

    // /**
    //  * @return AddRequest[] Returns an array of AddRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AddRequest
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
