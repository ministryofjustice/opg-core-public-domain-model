<?php
namespace OpgTest\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;use Opg\Core\Model\Entity\CaseItem\Document\Document;use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;use Opg\Core\Model\Entity\CaseItem\Note\Note;use Opg\Core\Model\Entity\CaseItem\Task\Task;use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;use Opg\Core\Model\Entity\User\User;

/**
 * ToArray test case.
 */
class CaseItemTest extends \PHPUnit_Framework_TestCase
{

    protected function getMockedClass()
    {
        return $this->getMockForAbstractClass('\Opg\Core\Model\Entity\CaseItem\CaseItem');
    }

    public function testSetGetStatus()
    {
        $caseItemMock = $this->getMockedClass();
        $expected     = 'Perfect';
        $caseItemMock->setStatus($expected);
        $this->assertEquals($expected, $caseItemMock->getStatus());
    }

    public function testSetGetCaseType()
    {
        $caseItemMock = $this->getMockedClass();
        $expected     = 'LPA';

        $caseItemMock->setCaseType($expected);
        $this->assertEquals($expected, $caseItemMock->getCaseType());
    }

    public function testSetGetCaseSubtype()
    {
        $caseItemMock = $this->getMockedClass();
        $expected     = 'Health and Welfare';

        $caseItemMock->setCaseSubtype($expected);
        $this->assertEquals($expected, $caseItemMock->getCaseSubtype());
    }

    public function testSetGetDueDate()
    {
        $caseItemMock = $this->getMockedClass();
        $expected     = '2014-09-25';

        $caseItemMock->setDueDate($expected);
        $this->assertEquals($expected, $caseItemMock->getDueDate());
    }

    public function testSetGetAssignedUser()
    {
        $caseItemMock = $this->getMockedClass();
        $name         = 'Test';
        $secondName   = 'User';

        $user = new User();
        $user->setFirstname($name)->setSurname($secondName);

        $caseItemMock->setAssignedUser($user);

        $this->assertEquals($name, $caseItemMock->getAssignedUser()->getFirstName());
    }

    public function testSetGetNotes()
    {
        $caseItemMock = $this->getMockedClass();

        $emptyCollection = $caseItemMock->getNotes()->toArray();

        $this->assertEmpty($emptyCollection);

        $noteCollection = new ArrayCollection();
        for ($i = 0; $i < 10; $i++) {
            $note = new Note();
            $note->setId($i);
            $noteCollection->add($note);
        }

        $caseItemMock->setNotes($noteCollection);

        $expected = 10;
        $array    = $caseItemMock->getNotes()->toArray();

        $this->assertEquals($expected, count($array));

        for ($i = 0; $i < 10; $i++) {
            $note = $array[$i];

            $this->assertEquals($i, $note->getId());
        }
    }

    public function testSetGetTasks()
    {
        $caseItemMock = $this->getMockedClass();

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setId($i);
            $caseItemMock->addTask($task);
        }

        $expected = 10;
        $array    = $caseItemMock->getTasks()->toArray();

        $this->assertEquals($expected, count($array));

        for ($i = 0; $i < 10; $i++) {
            $task = $array[$i];

            $this->assertEquals($i, $task->getId());
        }
    }

    public function testGetSetTaskCollections()
    {
        $caseItemMock = $this->getMockedClass();

        $emptyCollection = $caseItemMock->getTasks()->toArray();
        $this->assertEmpty($emptyCollection);

        $TaskCollection = new ArrayCollection();

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setId($i);
            $TaskCollection->add($task);
        }

        $caseItemMock->setTasks($TaskCollection);

        $taskCollectionArray = $caseItemMock->getTasks()->toArray();
        $this->assertEquals(
            count($TaskCollection->toArray()),
            count($taskCollectionArray)
        );
    }

    public function testSetGetDocuments()
    {
        $caseItemMock = $this->getMockedClass();

        $documentCollection = new ArrayCollection();
        for ($i = 0; $i < 10; $i++) {
            $document = new Document();
            $document->setId($i);
            $documentCollection->add($document);
        }

        $caseItemMock->setDocuments($documentCollection);

        $expected = 10;
        $array    = $caseItemMock->getDocuments()->toArray();

        $this->assertEquals($expected, count($array));

        for ($i = 0; $i < 10; $i++) {
            $document = $array[$i];

            $this->assertEquals($i, $document->getId());
        }
    }

    public function testGetIterator()
    {
        $caseItemMock = $this->getMockedClass();
        $iterator     = $caseItemMock->getIterator();

        $this->assertInstanceOf('ArrayIterator', $iterator);
    }

    public function testExchangeArray()
    {

        $caseItemMock = $this->getMockedClass();

        $expectedUserFirstName = 'Test';
        $expectedUserSurname   = ' User';
        $expectedUserId        = 1;


        $user = new User();
        $user->setFirstname($expectedUserFirstName)->setSurname($expectedUserSurname)->setId($expectedUserId);
        $caseItemMock->setAssignedUser($user);


        $tasks = new ArrayCollection();
        for ($i = 0; $i < 10; ++$i) {
            $currentTask = new Task();
            $currentTask->setId($i);
            $tasks->add($currentTask);
        }
        $caseItemMock->setTasks($tasks);

        $notes = new ArrayCollection();
        for ($i = 0; $i < 10; ++$i) {
            $currentNote = new Note();
            $currentNote->setId($i);
            $notes->add($currentNote);
        }
        $caseItemMock->setNotes($notes);

        $documents = new ArrayCollection();
        for ($i = 0; $i < 10; ++$i) {
            $currentDocument = new Document();
            $currentDocument->setId($i);
            $documents->add($currentDocument);
        }
        $caseItemMock->setDocuments($documents);

        $expectedArray = $caseItemMock->toArray();

        $caseItemMock2 = $caseItemMock->exchangeArray($expectedArray);

        $this->assertEquals($caseItemMock, $caseItemMock2);
    }

    public function testGetInputFilter()
    {
        $caseItemMock = $this->getMockedClass();

        $inputFilter = $caseItemMock->getInputFilter();

        $this->AssertTrue($inputFilter instanceof CaseItemFilter);
        $this->AssertFalse($inputFilter instanceof Zend\InputFilter\InputFilter);

    }

    public function testGetSetTitle()
    {
        $caseItemMock  = $this->getMockedClass();
        $expectedTitle = 'Mr';

        $caseItemMock->setTitle($expectedTitle);

        $this->assertEquals($expectedTitle, $caseItemMock->getTitle());
    }

    public function testGetSetId()
    {
        $caseItemMock = $this->getMockedClass();
        $expectedID   = '1234567890';

        $caseItemMock->setId($expectedID);

        $this->assertEquals($expectedID, $caseItemMock->getId());
    }

    public function testGetSetCaseItems()
    {
        $caseItemMock = $this->getMockedClass();

        $caseItems = new ArrayCollection();

        for ($i = 0; $i < 5; $i++) {
            $caseItems->add(new Lpa());
        }

        $caseItemMock->setCaseItems($caseItems);

        $this->assertEquals($caseItems, $caseItemMock->getCaseItems());
    }

    public function testIsNotValid()
    {
        $caseItemMock = $this->getMockedClass();

        $this->assertFalse($caseItemMock->isValid());
    }

    public function testIsValid()
    {
        $caseItemMock = $this->getMockedClass();
        $caseItemMock->addCaseItem(new Lpa());

        $this->assertTrue($caseItemMock->isValid());
    }
}