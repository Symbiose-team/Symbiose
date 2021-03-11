<?php

namespace App\Repository;

use App\Entity\ClaimMsg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClaimMsg|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClaimMsg|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClaimMsg[]    findAll()
 * @method ClaimMsg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClaimMsgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClaimMsg::class);
    }

    // /**
    //  * @return ClaimMsg[] Returns an array of ClaimMsg objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClaimMsg
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
