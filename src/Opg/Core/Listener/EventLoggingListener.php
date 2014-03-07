<?php

namespace Opg\Core\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\Deputyship\Deputyship;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;

/**
 * Logs events for entities which implement EventDataProvider.
 * @codeCoverageIgnore
 * These are covered by tests in the backend and will be moved over
 */
class EventLoggingListener implements EventSubscriber
{
    private $persistedEntities = array();

    /**
     * @var UserIdentityProvider
     */
    private $userIdentityProvider;

    public function __construct(UserIdentityProvider $identityProvider)
    {
        $this->userIdentityProvider = $identityProvider;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postLoad,
            Events::postPersist,
            Events::preUpdate,
            Events::preRemove,
            Events::postFlush,
        );
    }

    public function postLoad(LifecycleEventArgs $event)
    {
        $this->recordEvent($event->getEntityManager(), $event->getEntity(), 'READ');
    }

    public function postPersist(LifecycleEventArgs $event)
    {
        $this->persistedEntities[] = $event->getEntity();
    }

    public function postFlush(PostFlushEventArgs $event)
    {
        $em = $event->getEntityManager();
        foreach ($this->persistedEntities as $entity) {
            $this->recordEvent($em, $entity, 'INS');
        }

        $this->persistedEntities = array();
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        $changeset = $this->prepareChangeset($event->getEntityManager(), $event->getEntityChangeSet());
        $this->recordEvent($event->getEntityManager(), $event->getEntity(), 'UPD', $changeset);
    }

    public function preRemove(LifecycleEventArgs $event)
    {
        $this->recordEvent($event->getEntityManager(), $event->getEntity(), 'DEL');
    }

    private function prepareChangeset(EntityManager $em, array $changeset)
    {
        $simpleChangeset = array();
        foreach ($changeset as $field => $beforeAfter) {
            list($before, $after) = $beforeAfter;

            $simpleChangeset[$field] = array(
                $this->simplifyValue($em, $before),
                $this->simplifyValue($em, $after),
            );
        }

        return $simpleChangeset;
    }

    private function simplifyValue(EntityManager $em, $value)
    {
        if (is_object($value) && $em->contains($value)) {
            $simplifiedValue = array(
                'class' => ClassUtils::getClass($value),
                'identifier' => $em->getClassMetadata(ClassUtils::getClass($value))->getIdentifierValues($value),
            );

            return $simplifiedValue;
        }

        return $value;
    }

    private function recordEvent(EntityManager $em, $entity, $type, array $entityChangeset = null)
    {
        $currentUser = $this->userIdentityProvider->getUserIdentity();
        $owningEntity = $this->findOwningEntity($em, $entity);

        $em->getConnection()->executeQuery(
            "INSERT INTO events (sourceEntityId, sourceEntityClass, type, user_id, createdOn, changeset, owningEntityId, owningEntityClass, entity)
                 VALUES (:sourceId, :sourceEntityClass, :type, :createdByUser, :createdTime, :changeset, :owningEntityId, :owningEntityClass, :entity)",
            array(
                'sourceId'          => $this->getIdentifier($em, $entity),
                'sourceEntityClass' => ClassUtils::getClass($entity),
                'type'              => $type,
                'createdByUser'     => $currentUser ? $currentUser->getId() : null,
                'createdTime'       => (new \DateTime())->format('Y-m-d\TH:i:s'),
                'changeset'         => $entityChangeset,
                'owningEntityId'    => $owningEntity ? $this->getIdentifier($em, $owningEntity) : null,
                'owningEntityClass' => $owningEntity ? ClassUtils::getClass($owningEntity) : null,
                'entity'            => $entity->toArray(true),
            ),
            array(
                'changeset' => 'json_array',
                'entity'    => 'json_array'
            )
        );
    }

    private function findOwningEntity(EntityManager $em, $entity)
    {
        if ($entity instanceof Task) {
            return $this->findOwningEntityForTask($em, $entity);
        } elseif ($entity instanceof Note) {
            return $this->findOwningEntityForNote($em, $entity);
        } elseif ($entity instanceof Document) {
            return $this->findOwningEntityForDocument($em, $entity);
        } elseif ($entity instanceof CaseItem) {
            return $entity;
        } elseif ($entity instanceof Donor) {
            return $entity;
        } elseif ($entity instanceof Correspondent) {
            return $this->getCaseByPersonAttached($em,$entity,'correspondent');
        } elseif ($entity instanceof Attorney) {
            return $this->getCaseByAssociationMembership($em, $entity, 'attorneys');
        } elseif ($entity instanceof NotifiedPerson) {
            return $this->getCaseByAssociationMembership($em,$entity,'notifiedPersons');
        } elseif ($entity instanceof CertificateProvider) {
            return $this->getCaseByAssociationMembership($em,$entity,'certificateProviders');
        } elseif ($entity instanceof Address) {
            return $this->getAssociatedPerson($em,$entity,'addresses');
        } elseif ($entity instanceof PhoneNumber) {
            return $this->getAssociatedPerson($em,$entity,'phoneNumbers');
        }
        return null;
    }

    private function getAssociatedPerson(EntityManager $em, $entity, $attributeName)
    {
        $personObject = $em->createQuery(
            "SELECT p FROM Opg\Core\Model\Entity\Person\Person p WHERE :entity MEMBER OF p." . $attributeName
        )
            ->setParameter('entity', $entity->getId())
            ->getOneOrNullResult();

        if (!is_null($personObject)) {
            return $personObject;
        }

        throw new \LogicException('Could not find the person this entity was attached to');
    }

    private function findOwningEntityForTask(EntityManager $em, Task $task)
    {
        return $this->getCaseByAssociationMembership($em, $task, 'tasks');
    }

    private function findOwningEntityForNote(EntityManager $em, Note $note)
    {
        return $this->getCaseByAssociationMembership($em, $note, 'notes');
    }

    private function findOwningEntityForDocument(EntityManager $em, Document $document)
    {
        return $this->getCaseByAssociationMembership($em, $document, 'documents');
    }

    private function getCaseByPersonAttached(EntityManager $em, $entity, $personName)
    {
        $poa = $em->createQuery("SELECT c FROM Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney c WHERE c." . $personName ." = :entity")
            ->setParameter('entity', $entity->getId())
            ->getOneOrNullResult();
        if ($poa instanceof PowerOfAttorney) {
            return $poa;
        }

        $deputyship = $em->createQuery("SELECT c FROM Opg\Core\Model\Entity\Deputyship\Deputyship c WHERE c." . $personName ." = :entity")
            ->setParameter('entity', $entity->getId())
            ->getOneOrNullResult();
        if ($deputyship instanceof Deputyship) {
            return $deputyship;
        }

        throw new \LogicException(sprintf('Could not find case entity for class "%s".', ClassUtils::getClass($entity)));
    }

    private function getCaseByAssociationMembership(EntityManager $em, $entity, $associationName)
    {
        $poa = $em->createQuery("SELECT c FROM Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney c WHERE :entity MEMBER OF c.".$associationName)
            ->setParameter('entity', $entity)
            ->getOneOrNullResult();
        if ($poa instanceof PowerOfAttorney) {
            return $poa;
        }

        $deputyship = $em->createQuery("SELECT c FROM Opg\Core\Model\Entity\Deputyship\Deputyship c WHERE :entity MEMBER OF c.".$associationName)
            ->setParameter('entity', $entity)
            ->getOneOrNullResult();
        if ($deputyship instanceof Deputyship) {
            return $deputyship;
        }

        throw new \LogicException(sprintf('Could not find case entity for class "%s".', ClassUtils::getClass($entity)));
    }

    private function getIdentifier(EntityManager $em, $entity)
    {
        $compositeIdentifier = $em->getMetadataFactory()->getMetadataFor(ClassUtils::getClass($entity))->getIdentifierValues($entity);
        if (count($compositeIdentifier) > 1) {
            throw new \LogicException('EventLoggingListener does not support composite primary keys at the moment.');
        }

        $id = reset($compositeIdentifier);
        if ( ! is_numeric($id)) {
            throw new \LogicException(sprintf('Id must be an integer, but got "%s".', $id));
        }

        return (integer) $id;
    }
}
