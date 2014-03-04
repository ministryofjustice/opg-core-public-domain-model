<?php
namespace Opg\Core\Model\Entity\CaseItem;

use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use \Opg\Core\Model\Entity\User\User;
interface CaseItemInterface
{
    /**
     * @return string $caseId
     */
    public function getCaseId();

    /**
     * @param string $caseId
     */
    public function setCaseId($caseId);
    
    /**
     * @return string $dueDate
     */
    public function getDueDate();
    
    /**
     * @param string $dueDate
     */
    public function setDueDate($dueDate);
    
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
     * @return User $assignedUser
     */
    public function getAssignedUser();
    
    /**
     * @param string $status
     */
    public function setStatus($status);
    
    /**
     * @param User $assignedUser
     */
    public function setAssignedUser(User $assignedUser);
    
    /**
     *
     * @return \Opg\Core\Model\Entity\CaseItem\Task\TaskCollection
     */
    public function getTaskCollection();
    
    /**
     *
     * @return \Opg\Core\Model\Entity\CaseItem\Note\NoteCollection
     */
    public function getNoteCollection();
    
    /**
     *
     * @return \Opg\Core\Model\Entity\CaseItem\Document\DocumentCollection
     */
    public function getDocumentCollection();
    
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
    
    /**
     *
     * @param Document $document
     */
    public function addDocument(Document $document);
    
    /**
     * @return string
     */
    public function getExternalId();
    
    /**
     * @param string $externalId
     * @return CaseItemInterface
     */
    public function setExternalId($externalId);
}
