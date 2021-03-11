<?php

namespace App\Repository;

use App\Entity\Conversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Conversation[]    groupBy()
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    // /**
    //  * @return Conversation[] Returns an array of Conversation objects
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
    public function findOneBySomeField($value): ?Conversation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findConversationByParticipants(int $otherUserId,int $myId)
    {
        $qb=$this->createQueryBuilder('c');
        $qb ->select($qb->expr()->count('p.conversation'))
            ->innerJoin('c.participants','p')
            ->where(
                $qb->expr()->orX($qb->expr()->eq('p.user',':me')
                ->$qb->expr()->eq('p.user',':otherUser')))
            ->groupBy('p.conversation')
            ->having($qb->expr()->eq($qb->expr()->count('p.conversation'),2))


        ->setParameters(['me'=>$myId,'otherUser'=>$otherUserId])
    ;
        return $qb->getQuery()->getResult();
    }
}
