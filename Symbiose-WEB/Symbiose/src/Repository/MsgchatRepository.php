<?php

namespace App\Repository;

use App\Entity\Msgchat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Msgchat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Msgchat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Msgchat[]    findAll()
 * @method Msgchat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MsgchatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Msgchat::class);
    }

    // /**
    //  * @return Msgchat[] Returns an array of Msgchat objects
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
    public function findOneBySomeField($value): ?Msgchat
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
