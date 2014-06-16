<?php
namespace Opg\Core\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Id\SequenceGenerator;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\LuhnCheckDigit;

/**
 * Class UidSettingListener
 * @package Opg\Core\Listener
 * @codeCoverageIgnore
 * These are covered by tests in the backend and will be moved over
 */
class UidSettingListener implements EventSubscriber
{
    const SEQ_NAME = 'global_uid_seq';
    const ALLOCATION_SIZE = 3;

    private $idGenerator;

    public function __construct()
    {
        $this->idGenerator = new SequenceGenerator(self::SEQ_NAME, self::ALLOCATION_SIZE);
    }


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
            $entity->setUid($this->nextId($event->getEntityManager()));
        }
    }

    private function nextId(EntityManager $em)
    {
        $uid = $this->idGenerator->generate($em, null) + 70000000000;

        if ($uid > 79999999999) {
            throw new \LogicException('The maximum number of UIDs has been reached.');
        }

        return $uid . LuhnCheckDigit::createCheckSum($uid);
    }

    /**
     * @param GenerateSchemaEventArgs $event
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $event)
    {
        $schema = $event->getSchema();
        $schema->createSequence(self::SEQ_NAME, self::ALLOCATION_SIZE);
    }
}
