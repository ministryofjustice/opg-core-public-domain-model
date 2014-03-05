<?php

namespace Opg\Core\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;
use Opg\Common\Model\Entity\HasUidInterface;

class UidSettingListener implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            ToolEvents::postGenerateSchema,
            Events::prePersist
        );
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof HasUidInterface && $entity->getUid() === null) {
            $entity->setUid($this->nextId($event->getEntityManager()->getConnection()));
        }
    }

    private function nextId(Connection $con)
    {
        $con->executeQuery("INSERT INTO uids () VALUES ()");
        $uid = $con->lastInsertId();

        if ($uid === false) {
            throw new \LogicException('Could not retrieve last inserted id.');
        }

        if ($uid >= 700000000000) {
            throw new \LogicException('The maximum number of UIDs has been reached.');
        }

        return 700000000000 + (integer) $uid;
    }

    public function postGenerateSchema(GenerateSchemaEventArgs $event)
    {
        $schema = $event->getSchema();

        $uidTable = $schema->createTable('uids');
        $uidTable->addColumn('id', 'bigint', array('unsigned' => true, 'autoincrement' => true));
        $uidTable->setPrimaryKey(array('id'));
    }
}