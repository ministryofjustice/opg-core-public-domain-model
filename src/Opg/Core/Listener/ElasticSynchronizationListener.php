<?php
namespace Opg\Core\Listener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\UnitOfWork;
use Elasticsearch\Client;
use JMS\Serializer\SerializationContext;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Page\Page;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Common\Model\Entity\EntityInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ElasticSynchronizationListener
 * @package Opg\Core\Listener
 * @codeCoverageIgnore
 * These are covered by tests in the backend and will be moved over
 */
class ElasticSynchronizationListener implements EventSubscriber
{
    private $client;
    private $caseIndex;
    private $serviceLocator;

    /**
     * @param Client $client
     * @param        $caseIndex
     */
    public function __construct(Client $client, $caseIndex)
    {
        $this->client    = $client;
        $this->caseIndex = $caseIndex;
    }

    /**
     * Set serviceManager instance
     *
     * @param  ServiceLocatorInterface $serviceLocator
     *
     * @return ElasticSynchronizationListener
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::onFlush,
        );
    }

    /**
     * @param OnFlushEventArgs $event
     */
    public function onFlush(OnFlushEventArgs $event)
    {
        if ($this->serviceLocator === null) {
            return;
        }

        $changedCases = $this->collectChangedCases($event);
        foreach ($changedCases as $case) {
            $params = array(
                'type'  => $case->getCaseSubtype(),
                'index' => $this->caseIndex,
                'id'    => $case->getUid()
            );

            try {
                $this->client->delete($params);
            } catch (\Exception $e) {
                $this->getServiceLocator()
                    ->get('Logger')
                    ->warn(
                        'Error Occurred indexing item. See tcpflow port 9200 to see actual error' . PHP_EOL .
                        $e->getMessage() . PHP_EOL
                    );
            }

            $this->client->create(
                array_merge(
                    array(
                        'body' => json_decode(
                            $this->getServiceLocator()
                                ->get('Serializer')
                                ->serialize(
                                    $case,
                                    'json',
                                    SerializationContext::create()->enableMaxDepthChecks()
                                )
                            ,
                            true
                        )
                    ),
                    $params
                )
            );
        }
    }

    /**
     * @param OnFlushEventArgs $event
     *
     * @return array
     */
    private function collectChangedCases(OnFlushEventArgs $event)
    {
        $uow = $event->getEntityManager()->getUnitOfWork();

        $changedCases = array();
        foreach ($this->computeDirtyEntities($uow) as $entity) {
            $this->addCases($changedCases, $this->getCasesForEntity($event->getEntityManager(), $entity));
        }

        return $changedCases;
    }

    /**
     * @param UnitOfWork $uow
     *
     * @return array
     */
    private function computeDirtyEntities(UnitOfWork $uow)
    {
        $dirtyEntities = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates(),
            $uow->getScheduledEntityDeletions()
        );

        foreach (array_merge(
                     $uow->getScheduledCollectionUpdates(),
                     $uow->getScheduledCollectionDeletions()
                 ) as $collection) {
            if (!$collection instanceof PersistentCollection) {
                continue;
            }

            if (in_array($collection->getOwner(), $dirtyEntities, true)) {
                continue;
            }

            $dirtyEntities[] = $collection->getOwner();
        }

        return $dirtyEntities;
    }

    /**
     * @param EntityManager $em
     * @param               $entity
     *
     * @return array
     */
    private function getCasesForEntity(EntityManager $em, $entity)
    {
        if ($entity instanceof CaseItem) {
            return array($entity);
        } elseif ($entity instanceof Page) {
            return $this->getCasesForPage($em, $entity);
        } elseif ($entity instanceof Document) {
            return $this->getCasesForDocument($em, $entity);
        } elseif ($entity instanceof Person) {
            return $this->getCasesForPerson($entity);
        } elseif ($entity instanceof Task) {
            return $this->getCasesForTask($em, $entity);
        } elseif ($entity instanceof Note) {
            return $this->getCasesForNote($em, $entity);
        }

        return array();
    }

    /**
     * @param Person $person
     *
     * @return array
     */
    private function getCasesForPerson(Person $person)
    {
        $cases = array_merge(
            $person->getPowerOfAttorneys()->toArray(),
            $person->getDeputyships()->toArray()
        );

        return $cases;
    }

    /**
     * @param EntityManager $em
     * @param Page          $page
     *
     * @return array
     */
    private function getCasesForPage(EntityManager $em, Page $page)
    {
        return $this->getCasesForDocument($em, $page->getDocument());
    }

    /**
     * @param EntityManager $em
     * @param Document      $document
     *
     * @return array
     */
    private function getCasesForDocument(EntityManager $em, Document $document)
    {
        return $this->getCasesByAssociationMembership($em, $document, 'documents');
    }

    /**
     * @param EntityManager $em
     * @param Note          $note
     *
     * @return array
     */
    private function getCasesForNote(EntityManager $em, Note $note)
    {
        return $this->getCasesByAssociationMembership($em, $note, 'notes');
    }

    /**
     * @param EntityManager $em
     * @param Task          $task
     *
     * @return array
     */
    private function getCasesForTask(EntityManager $em, Task $task)
    {
        return $this->getCasesByAssociationMembership($em, $task, 'tasks');
    }

    /**
     * @param EntityManager $em
     * @param               $entity
     * @param               $associationName
     *
     * @return array
     */
    private function getCasesByAssociationMembership(EntityManager $em, $entity, $associationName)
    {
        // If the entity has not been inserted into the database just yet, we cannot determine
        // the case in this direction. This is not problematic though as the case itself must be
        // part of the changeset as a new item has been added to one of its collections.
        $id = $em->getClassMetadata(ClassUtils::getClass($entity))->getIdentifierValues($entity);
        if (empty($id)) {
            return array();
        }

        $pas = $em->createQuery(
            "SELECT c FROM Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney c WHERE :entity MEMBER OF c." . $associationName
        )
            ->setParameter('entity', $entity)
            ->getResult();

        $deputyships = $em->createQuery(
            "SELECT c FROM Opg\Core\Model\Entity\Deputyship\Deputyship c WHERE :entity MEMBER OF c." . $associationName
        )
            ->setParameter('entity', $entity)
            ->getResult();

        return array_merge($pas, $deputyships);
    }

    /**
     * @param array $cases
     * @param array $caseItems
     */
    private function addCases(array &$cases, array $caseItems)
    {
        foreach ($caseItems as $item) {
            if (in_array($item, $cases, true)) {
                continue;
            }

            $cases[] = $item;
        }
    }
}
