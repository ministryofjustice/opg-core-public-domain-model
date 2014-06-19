<?php
namespace OpgTest\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;
use Opg\Core\Model\Entity\User\User;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

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

    public function testSetGetCaseTypeReturnsUpperCase()
    {
        $caseItemMock = $this->getMockedClass();
        $expected     = 'LPA';

        $caseItemMock->setCaseType(strtolower($expected));
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

        $caseItemMock->setDueDateString('');
        $this->assertEmpty($caseItemMock->getDueDate());
        $this->assertEmpty($caseItemMock->getDueDateString());

        $expected     = new \DateTime('2014-09-25');

        $caseItemMock->setDueDate($expected);
        $this->assertEquals($expected, $caseItemMock->getDueDate());

        $expectedString = '2014-09-25';
        try {
            $caseItemMock->setDueDateString($expectedString);
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'2014-09-25' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testGetSetDueDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $caseItemMock = $this->getMockedClass();

        $caseItemMock->setDueDateString($expected);
        $this->assertEquals($expected, $caseItemMock->getDueDateString());
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
        $caseItemMock->addNotes($notes);

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
        $this->AssertTrue($inputFilter instanceof \Zend\InputFilter\InputFilter);

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

    public function testGetSetTaskStatus()
    {
        $seedStatus = array(
            array('status' => 'Open', 'counter' => 1),
            array('status' => 'Pending', 'counter' => 3),
            array('status' => 'Closed', 'counter' =>5)
        );

        $statuses = array(
            'Open' => 1,
            'Pending' => 3,
            'Closed'  => 5
        );

        $caseItemMock = $this->getMockedClass();
        $caseItemMock->setTaskStatus($seedStatus);
        $this->assertEquals($statuses, $caseItemMock->getTaskStatus());
    }

    public function testGetSetApplicationType()
    {
        $caseItemMock = $this->getMockedClass();
        $this->assertEquals($caseItemMock->getApplicationType(), 'Classic');
        $caseItemMock->setApplicationType('Online');
        $this->assertEquals($caseItemMock->getApplicationType(), 'Online');
    }

    public function testGetOldCaseId()
    {
        $expectedId = 'OLD_CASE_' . uniqid();

        $caseItemMock = $this->getMockedClass();
        $this->assertNull($caseItemMock->getOldCaseId());

        $caseItemMock->setOldCaseId($expectedId);
        $this->assertEquals($expectedId, $caseItemMock->getOldCaseId());
    }

    public function testGetSetRegistrationDate()
    {
        $caseItemMock = $this->getMockedClass();

        try {
            $caseItemMock->setRegistrationDateString('');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }

        $this->assertEmpty($caseItemMock->getRegistrationDate());
        $this->assertEmpty($caseItemMock->getRegistrationDateString());

        $expected     = new \DateTime('2014-09-25');

        $caseItemMock->setRegistrationDate($expected);
        $this->assertEquals($expected, $caseItemMock->getRegistrationDate());

        $expectedString = '2014-09-25';

        try {
            $caseItemMock->setRegistrationDateString($expectedString);
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'2014-09-25' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
        $expected     = new \DateTime($expectedString);
        $this->assertEquals($expected->format('d/m/Y'), $caseItemMock->getRegistrationDateString());

        $expectedString = date(OPGDateFormat::getDateFormat());
        $caseItemMock->setRegistrationDateString($expectedString);
        $this->assertEquals($expectedString, $caseItemMock->getRegistrationDateString());

    }

    public function testGetSetClosedDate()
    {
        $expectedDate = new \DateTime();
        $caseItemMock = $this->getMockedClass();

        $this->assertNull($caseItemMock->getClosedDate());
        $caseItemMock->setClosedDate($expectedDate);
        $this->assertEquals($expectedDate, $caseItemMock->getClosedDate());
    }

    public function testGetSetClosedDateNulls()
    {
        $expectedDate = new \DateTime();
        $caseItemMock = $this->getMockedClass();

        $this->assertEmpty($caseItemMock->getClosedDate());
        $caseItemMock->setClosedDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $caseItemMock->getClosedDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetClosedDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $caseItemMock = $this->getMockedClass();

        $caseItemMock->setClosedDateString($expected);
        $this->assertEquals($expected, $caseItemMock->getClosedDateString());
    }

    public function testGetSetClosedDateStringNull()
    {
        $expected = null;

        $caseItemMock = $this->getMockedClass();

        $caseItemMock->setClosedDateString($expected);
        $this->assertEquals($expected, $caseItemMock->getClosedDateString());
        $this->assertEmpty($caseItemMock->getClosedDateString());
    }

    public function testGetSetClosedDateStringInvalidDate()
    {
        $caseItemMock = $this->getMockedClass();

        $this->assertEmpty($caseItemMock->getClosedDateString());
        try {
            $caseItemMock->setClosedDateString('');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }

        $this->assertEmpty($caseItemMock->getClosedDateString());
    }

}
