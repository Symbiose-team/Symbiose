<?php

namespace App\Repository;

use App\Entity\Proda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Proda|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proda|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proda[]    findAll()
 * @method Proda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProdaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proda::class);
    }

    // /**
    //  * @return Proda[] Returns an array of Proda objects
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
    public function findOneBySomeField($value): ?Proda
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
