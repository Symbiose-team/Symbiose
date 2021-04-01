<?php
declare(strict_types=1);
/**
 * File: JoinNotificationSubscriber.php
 *
 * @author    Michal Broniszewski <michal.broniszewski@lizardmedia.pl>
 * @copyright Copyright (C) 2018 Lizard Media (http://lizardmedia.pl)
 */

namespace App\EventListener;


use App\Entity\JoinNotification;
use App\Entity\Game;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

/**
 * Class JoinNotificationSubscriber
 * @package App\EventListener
 */
class JoinNotificationSubscriber implements EventSubscriber
{
    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }

    /**
     * @param OnFlushEventArgs $eventArgs
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        $em = $eventArgs->getEntityManager();
        $uow = $em->getUnitOfWork();

        /** @var PersistentCollection $collectionUpdate */
        foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdate) {
            if (!$collectionUpdate->getOwner() instanceof Game) {
                continue;
            }

            if ('joinedBy' !== $collectionUpdate->getMapping()['fieldName']) {
                continue;
            }

            $insertDiff = $collectionUpdate->getInsertDiff();

            if (!count($insertDiff)) {
                return;
            }

            /** @var Game $game */
            $game = $collectionUpdate->getOwner();

            $notification = new JoinNotification();
            $notification->setUser($game->getUser());
            $notification->setGame($game);
            $notification->setJoinedBy(reset($insertDiff));

            $em->persist($notification);

            $uow->computeChangeSet(
                $em->getClassMetadata(JoinNotification::class),
                $notification
            );
        }
    }
}
