<?php

namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItem as CaseEntity;
use Opg\Core\Model\Entity\CaseItem\Task\Task as TaskEntity;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney as PowerOfAttorneyEntity;
use Opg\Core\Model\Entity\Deputyship\Deputyship as DeputyshipEntity;

/**
 * Interface IsAssignee
 * @package Opg\Core\Model\Entity\Assignable
 */
interface IsAssignee
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     *
     * @return IsAssignee
     */
    public function setId( $id );

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return IsAssignee
     */
    public function setName( $name );

    /**
     * @param TaskEntity $task
     *
     * @return IsAssignee
     */
    public function addTask( TaskEntity $task );

    /**
     * @param ArrayCollection $tasks
     *
     * @return IsAssignee
     */
    public function setTasks( ArrayCollection $tasks );

    /**
     * @return ArrayCollection
     */
    public function getTasks();

    /**
     * @param CaseEntity $case
     *
     * @return IsAssignee
     */
    public function addCase( CaseEntity $case );

    /**
     * @return ArrayCollection
     */
    public function getCases();

    /**
     * @param PowerOfAttorneyEntity $poa
     *
     * @return IsAssignee
     */
    public function addPowerOfAttorney( PowerOfAttorneyEntity $poa );

    /**
     * @return ArrayCollection
     */
    public function getPowerOfAttorneys();

    /**
     * @param DeputyshipEntity $poa
     *
     * @return IsAssignee
     */
    public function addDeputyship( DeputyshipEntity $poa );

    /**
     * @return ArrayCollection
     */
    public function getDeputyships();

    /**
     * @param ArrayCollection $cases
     *
     * @return IsAssignee
     */
    public function setCases( ArrayCollection $cases );

    /**
     * @param ArrayCollection $cases
     *
     * @return IsAssignee
     * Alias function
     */
    public function setPowerOfAttorneys( ArrayCollection $cases );

    /**
     * @param ArrayCollection $cases
     *
     * @return IsAssignee
     * Alias function
     */
    public function setDeputyships( ArrayCollection $cases );
}
