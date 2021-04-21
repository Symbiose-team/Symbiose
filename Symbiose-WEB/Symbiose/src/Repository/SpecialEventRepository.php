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

    public function status() : array
    {
        return $this->createQueryBuilder('p')
            ->where('p.State = 1')
            ->getQuery()
            ->getResult();
    }
}