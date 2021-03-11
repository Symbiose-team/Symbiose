<?php

namespace App\Repository;

use App\Entity\AnswerClaim;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AnswerClaim|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnswerClaim|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnswerClaim[]    findAll()
 * @method AnswerClaim[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerClaimRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnswerClaim::class);
    }

    // /**
    //  * @return AnswerClaim[] Returns an array of AnswerClaim objects
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
    public function findOneBySomeField($value): ?AnswerClaim
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
