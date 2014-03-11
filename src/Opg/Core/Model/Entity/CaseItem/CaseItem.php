<?php

/**
 * @package Opg Core Domain Model
 */
namespace Opg\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\User\User;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\MappedSuperclass
 */
abstract class CaseItem implements EntityInterface, \IteratorAggregate, CaseItemInterface, HasUidInterface, HasNotesInterface
{
    use ToArray;
    use HasNotes;
    use UniqueIdentifier;
    use InputFilter;

    /**
     * @ORM\Column(type = "integer") @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var number autoincrementID
     */
    protected $id;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $title
     * @Type("string")
     */
    protected $title;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $caseType;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $caseSubtype;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $dueDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $status;

    /**
     * @Serializer\MaxDepth(1)
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\User\User", fetch = "EAGER")
     * @var User
     */
    protected $assignedUser;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Task\Task", fetch="EAGER")
     * @var ArrayCollection
     */
    protected $tasks;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note")
     * @var ArrayCollection
     */
    protected $notes;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Document\Document")
     * @var ArrayCollection
     */
    protected $documents;


    // Fields below are NOT persisted
    /**
     * @var ArrayCollection
     * @todo Move this out of the CaseItem, need to be used in validation, but needs to exist somewhere else
     */
    protected $caseItems;

    /**
     * @var array
     * This is used to getTaskStatus counts, we do not persist it though
     */
    protected $taskStatus = [];

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->caseItems = new ArrayCollection();
    }

    /**
     * @return string $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
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
    public function setAssignedUser(User $assignedUser = null)
    {
        $this->assignedUser = $assignedUser;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task)
    {
        $this->tasks->add($task);
    }

    /**
     * @param Document $document
     * @return $this
     */
    public function addDocument(Document $document)
    {
        $this->documents->add($document);

        return $this;
    }

    /**
     * @param ArrayCollection $tasks
     * @return CaseItem
     */
    public function setTasks(ArrayCollection $tasks)
    {
        foreach ($tasks as $task) {
            $this->addTask($task);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $documents
     * @return CaseItem
     */
    public function setDocuments(ArrayCollection $documents)
    {
        foreach ($documents as $document) {
            $this->addDocument($document);
        }

        return $this;
    }


    /**
     * @param array $data
     * @return CaseItem
     */
    public function exchangeArray(array $data)
    {
        empty($data['id']) ? : $this->setId($data['id']);
        empty($data['uid']) ? : $this->setUid($data['uid']);
        empty($data['caseType']) ? : $this->setCaseType($data['caseType']);
        empty($data['caseSubtype']) ? : $this->setCaseSubtype($data['caseSubtype']);
        empty($data['dueDate']) ? : $this->setDueDate($data['dueDate']);
        empty($data['status']) ? : $this->setStatus($data['status']);
        empty($data['title']) ? : $this->setTitle($data['title']);

        if (!empty($data['assignedUser'])) {
            $assignedUser = new User();
            $assignedUser->exchangeArray($data['assignedUser']);
            $this->setAssignedUser($assignedUser);
        }

        if (!empty($data['tasks'])) {
            foreach ($data['tasks'] as $taskData) {
                $newTask = new Task();
                $this->addTask(is_object($taskData) ? $taskData : $newTask->exchangeArray($taskData));
            }
        }

        if (!empty($data['notes'])) {
            foreach ($data['notes'] as $noteData) {
                $newNote = new Note();
                $this->addNote(is_object($noteData) ? $noteData : $newNote->exchangeArray($noteData));
            }
        }

        if (!empty($data['documents'])) {
            foreach ($data['documents'] as $documentData) {
                $newDocument = new Document();
                $this->addDocument(is_object($documentData) ? $documentData : $newDocument->exchangeArray($documentData));
            }
        }
        return $this;
    }


    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CaseItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    /**
     * @param number $id
     * @return CaseItem
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getCaseItems()
    {
        return $this->caseItems;
    }


    /**
     * @param ArrayCollection $caseItems
     * @return CaseItem
     */
    public function setCaseItems(ArrayCollection $caseItems)
    {
        foreach ($caseItems as $item) {
            $this->addCaseItem($item);
        }

        return $this;
    }

    /**
     * @param CaseItem $item
     * @return CaseItem
     */
    public function addCaseItem(CaseItem $item)
    {
        $this->caseItems->add($item);

        return $this;
    }

    /**
     * @return InputFilter|CaseItemFilter|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new CaseItemFilter();
        }

        return $this->inputFilter;
    }

    /**
     * @return array
     */
    public function getTaskStatus()
    {
        return $this->taskStatus;
    }

    /**
     * @param array $taskStatus
     * @return CaseItem
     */
    public function setTaskStatus(array $taskStatus)
    {
        foreach($taskStatus as $item) {
            $this->taskStatus[str_replace(' ' ,'',$item['status'])] = $item['counter'];
        }
        return $this;
    }

    /**
     * @param Person $person
     * @return CaseItem
     */
   abstract public function addPerson(Person $person);

}
