<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\EventSearch;
use App\Entity\EventUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */

    public function findPlayersRemaining() : array
    {
        return $this->createQueryBuilder('e')
            ->where('e.NumRemaining = 100')
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */

    public function status_false() : array
    {
        return $this->createQueryBuilder('e')
            ->where('e.State = 0')
            ->getQuery()
            ->getResult();
    }

    public function status_true() : array
    {
        return $this->createQueryBuilder('e')
            ->where('e.State = 1')
            ->getQuery()
            ->getResult();
    }

    public function find_by_user($name)
    {
        $qb = $this->createQueryBuilder('e');

        $qb
            ->where('e.State = 1')
            ->andWhere('e.Supplier like :Supplier')
            ->setParameter('Supplier',$name);

        dump($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }

    /*
     * @return Query
     */
    public function search(EventSearch $search): Query
    {
        $qb = $this->createQueryBuilder('e');

        if ($search->getType()) {
            $qb
                ->where('e.State = 1')
                ->andWhere('e.Type like :Type')
                ->setParameter('Type', $search->getType());

            dump($qb->getQuery()->getResult());

        }
        else{
            $qb
                ->where('e.State = 1');
        }
        return $qb->getQuery();
    }
}
