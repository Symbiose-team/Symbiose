<?php

namespace App\Repository;

use App\Entity\JoinNotification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JoinNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method JoinNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method JoinNotification[]    findAll()
 * @method JoinNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoinNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JoinNotification::class);
    }




    // /**
    //  * @return JoinNotification[] Returns an array of JoinNotification objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JoinNotification
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
