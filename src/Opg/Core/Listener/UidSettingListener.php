<?php
namespace Opg\Core\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;
use Opg\Common\Model\Entity\HasUidInterface;

/**
 * Class UidSettingListener
 * @package Opg\Core\Listener
 * @codeCoverageIgnore
 * These are covered by tests in the backend and will be moved over
 */
class UidSettingListener implements EventSubscriber
{

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            ToolEvents::postGenerateSchema,
            Events::prePersist
        );
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if ($entity instanceof HasUidInterface && $entity->getUid() === null) {
            $entity->setUid($this->nextId($event->getEntityManager()->getConnection()));
        }
    }

    /**
     * @param Connection $con
     *
     * @return int
     * @throws \LogicException
     */
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

        return 700000000000 + (integer)$uid;
    }

    /**
     * @param GenerateSchemaEventArgs $event
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $event)
    {
        $schema = $event->getSchema();

        $uidTable = $schema->createTable('uids');
        $uidTable->addColumn('id', 'bigint', array('unsigned' => true, 'autoincrement' => true));
        $uidTable->setPrimaryKey(array('id'));
    }
}
