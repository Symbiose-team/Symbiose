<?php

namespace App\Repository;

use App\Entity\Prodaa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prodaa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prodaa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prodaa[]    findAll()
 * @method Prodaa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdaaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prodaa::class);
    }

    // /**
    //  * @return Prodaa[] Returns an array of Prodaa objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prodaa
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
