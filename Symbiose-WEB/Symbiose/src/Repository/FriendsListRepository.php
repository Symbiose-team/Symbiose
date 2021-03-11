<?php

namespace App\Repository;

use App\Entity\FriendsList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FriendsList|null find($id, $lockMode = null, $lockVersion = null)
 * @method FriendsList|null findOneBy(array $criteria, array $orderBy = null)
 * @method FriendsList[]    findAll()
 * @method FriendsList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendsListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FriendsList::class);
    }

    // /**
    //  * @return FriendsList[] Returns an array of FriendsList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FriendsList
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
