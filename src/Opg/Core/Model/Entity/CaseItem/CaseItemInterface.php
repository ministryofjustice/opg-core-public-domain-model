<?php
namespace Opg\Core\Model\Entity\CaseItem;

use Opg\Core\Model\Entity\Note\Note;
use Opg\Core\Model\Entity\Task\Task;

/**
 * Interface CaseItemInterface
 * @package Opg\Core\Model\Entity\CaseItem
 */
interface CaseItemInterface
{
    /**
     * @return string $dueDate
     */
    public function getDueDate();

    /**
     * @param \DateTime $dueDate
     */
    public function setDueDate(\DateTime $dueDate);

    /**
     * @return string $caseType
     */
    public function getCaseType();

    /**
     * @param string $caseType
     */
    public function setCaseType($caseType);

    /**
     * @return string $caseSubtype
     */
    public function getCaseSubtype();

    /**
     * @param string $caseSubtype
     */
    public function setCaseSubtype($caseSubtype);

    /**
     * @return string $status
     */
    public function getStatus();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTasks();

    /**
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getNotes();

    /**
     *
     * @param Task $task
     */
    public function addTask(Task $task);

    /**
     *
     * @param Note $note
     */
    public function addNote(Note $note);

}
