<?php

/**
 * @package Opg Core Domain Model
 */

namespace Opg\Core\Model\Entity\CaseItem\Traits;

use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Task\TaskCollection;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Document\DocumentCollection;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Note\NoteCollection;
use Opg\Core\Model\Entity\User\User;

trait CaseItem
{
    /**
     * @var string $caseId
     */
    private $caseId;
    
    /**
     * @var string
     */
    private $caseType;
    
    /**
     * @var string
     */
    private $caseSubtype;
    
    /**
     * @var string
     */
    private $dueDate;
    
    /**
     * @var string
     */
    private $status;

    /**
     * @var User
     */
    private $assignedUser;

    /**
     * @var TaskCollection $taskCollection
     */
    private $taskCollection = null;
    
    /**
     * @var NoteCollection $noteCollection
     */
    private $noteCollection = null;
    
    /**
     * @var DocumentCollection $documentCollection
     */
    private $documentCollection = null;

    /**
     * @var string
     */
    private $externalId;

    /**
     * @return string $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }
    
    /**
     * @return string $caseId
     */
    public function getCaseId()
    {
        return $this->caseId;
    }
    
    /**
     * @param string $caseId
     * @return $this
     */
    public function setCaseId($caseId)
    {
        $this->caseId = $caseId;
        return $this;
    }

    /**
     * @param string $dueDate
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string $caseType
     */
    public function getCaseType()
    {
        return $this->caseType;
    }

    /**
     * @param string $caseType
     */
    public function setCaseType($caseType)
    {
        $this->caseType = $caseType;
    }

    /**
     * @return string $caseSubtype
     */
    public function getCaseSubtype()
    {
        return $this->caseSubtype;
    }

    /**
     * @param string $caseSubtype
     */
    public function setCaseSubtype($caseSubtype)
    {
        $this->caseSubtype = $caseSubtype;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return User $assignedUser
     */
    public function getAssignedUser()
    {
        return $this->assignedUser;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param User $assignedUser
     */
    public function setAssignedUser(User $assignedUser)
    {
        $this->assignedUser = $assignedUser;
    }

    /**
     *
     * @return \Opg\Core\Model\Entity\CaseItem\Task\TaskCollection
     */
    public function getTaskCollection()
    {
        if ($this->taskCollection == null) {
            $this->taskCollection = new TaskCollection();
        }
        return $this->taskCollection;
    }

    /**
     *
     * @return \Opg\Core\Model\Entity\CaseItem\Note\NoteCollection
     */
    public function getNoteCollection()
    {
        if ($this->noteCollection == null) {
	        $this->noteCollection = new NoteCollection();
        }
        return $this->noteCollection;
    }

    /**
     * @param NoteCollection $notes
     * @return $this
     */
    public function setNoteCollection(NoteCollection $notes)
    {
        $this->noteCollection = $notes;

        return $this;
    }

    /**
     *
     * @return \Opg\Core\Model\Entity\CaseItem\Document\DocumentCollection
     */
    public function getDocumentCollection()
    {
        return $this->documentCollection;
    }

    /**
     * @param DocumentCollection $documents
     * @return $this
     */
    public function setDocumentCollection(DocumentCollection $documents) {
        $this->documentCollection = $documents;

        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task)
    {
        if ($this->taskCollection == null) {
            $this->taskCollection = new TaskCollection();
        }
        $this->taskCollection->addTask($task);
        return $this;
    }

    /**
     * @param TaskCollection $taskCollection
     *
     * @return $this
     */
    public function setTaskCollection(TaskCollection $taskCollection)
    {
        $this->taskCollection = $taskCollection;
        return $this;
    }

    /**
     * @param Note $note
     * @return $this
     */
    public function addNote(Note $note)
    {
        if ($this->noteCollection == null) {
            $this->noteCollection = new NoteCollection();
        }
        $this->noteCollection->addNote($note);
        return $this;
    }

    /**
     * @param Document $document
     * @return $this
     */
    public function addDocument(Document $document)
    {
        if ($this->documentCollection == null) {
            $this->documentCollection = new DocumentCollection();
        }
        $this->documentCollection->addDocument($document);
        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $data = get_object_vars($this);

        return $data;
    }

    public function toArray() {
        $data = $this->getArrayCopy();

        if (!empty($data['assignedUser'])) {
            $data['assignedUser'] = $data['assignedUser']->toArray();
        }
        if (!empty($data['taskCollection'])) {
            $data['taskCollection'] = $data['taskCollection']->toArray();
        }
        if (!empty($data['noteCollection'])) {
            $data['noteCollection'] = $data['noteCollection']->toArray();
        }
        if (!empty($data['documentCollection'])) {
            $data['documentCollection'] = $data['documentCollection']->toArray();
        }

        return $data;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getArrayCopy());
    }

    /**
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
        return $this;
    }
}
