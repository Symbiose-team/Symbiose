<?php

namespace App\Repository;

use App\Entity\MsgText;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MsgText|null find($id, $lockMode = null, $lockVersion = null)
 * @method MsgText|null findOneBy(array $criteria, array $orderBy = null)
 * @method MsgText[]    findAll()
 * @method MsgText[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MsgTextRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MsgText::class);
    }

    // /**
    //  * @return MsgText[] Returns an array of MsgText objects
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
    public function findOneBySomeField($value): ?MsgText
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
