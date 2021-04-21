<?php

namespace App\Repository;

use App\Entity\EventUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EventUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventUser[]    findAll()
 * @method EventUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventUser::class);
    }
}
