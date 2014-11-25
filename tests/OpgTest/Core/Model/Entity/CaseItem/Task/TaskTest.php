<?php
namespace OpgTest\Core\Model\CaseItem\Task;

use Opg\Core\Model\Entity\Assignable\NullEntity;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\User\User;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * Task test case.
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Task
     */
    private $task;

    /**
     * @var array
     */
    private $data = array(
        'id'            => 123,
        'type'          => 'tasklet',
        'systemType'    => null,
        'status'        => 'Registered',
        'name'          => 'Test name',
        'description'   => 'Test Description',
        'assignedUser'  => null,
        'priority'      => 'high',
        'errorMessages' => array(),
        'case'          => null,
        'ragRating'     => null
    );

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->data['createdTime'] = new \DateTime();
        $this->data['dueDate'] = new \DateTime();
        $this->data['activeDate'] = new \DateTime();
        $this->data['completedDate'] = new \DateTime();
        $this->task = new Task();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->task = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->task->getIterator());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->task->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);

    }

    public function testNew()
    {
        $data = array();
        $data['completedDate'] = '04/06/2014 11:23:45';
        $this->task->setDateFromString($data['completedDate'], 'completedDate');
        $this->assertEquals('04/06/2014 11:23:45', $this->task->getDateTimeAsString('completedDate'));
    }

    public function testGetSetId()
    {
        $id = 13123;

        $this->task->setId($id);

        $this->assertEquals(
            $id,
            $this->task->getId()
        );
    }

    public function testGetSetType()
    {
        $tasktype = 123;

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Task\Task',
            $this->task->setType($tasktype)
        );

        $this->assertEquals(
            $tasktype,
            $this->task->getType()
        );
    }

    public function testGetSetSystemType()
    {
        $tasktype = 456;

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Task\Task',
            $this->task->setSystemType($tasktype)
        );

        $this->assertEquals(
            $tasktype,
            $this->task->getSystemType()
        );
    }

    public function testGetSetPriority()
    {
        $priority = 'High';

        $this->task->setPriority($priority);

        $this->assertEquals(
            $priority,
            $this->task->getPriority()
        );
    }

    public function testGetSetStatus()
    {
        $status = 'Complete';

        $this->task->setStatus($status);

        $this->assertEquals(
            $status,
            $this->task->getStatus()
        );
    }

    public function testGetSetDueDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->task->getDueDate());
        $this->assertEmpty($this->task->getDateAsString('dueDate'));

        $this->task->setDueDate($expectedDate);
        $this->assertEquals($expectedDate, $this->task->getDueDate());
    }

    public function testGetSetDueDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->task->getDueDate());
        $this->task->setDueDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->task->getDueDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetDueDateEmptyString()
    {

        $this->assertEmpty($this->task->getDateAsString('dueDate'));
        $this->task->setDateFromString('','dueDate');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateTimeFormat(),
                $this->task->getDateAsString('dueDate')
            );

        $this->assertEmpty(
            $returnedDate
        );
    }

    public function testGetSetActiveDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->task->getActiveDate());
        $this->assertEmpty($this->task->getDateAsString('activeDate'));

        $this->task->setActiveDate($expectedDate);
        $this->assertEquals($expectedDate, $this->task->getActiveDate());
    }

    public function testGetSetActiveDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->task->getActiveDate());
        $this->task->setActiveDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->task->getActiveDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetActiveDateEmptyString()
    {
        $expectedDate = OPGDateFormat::createDateTime(date(OPGDateFormat::getDateFormat().' 00:00:00'));

        $this->assertEmpty($this->task->getDateAsString('activeDate'));
        $this->task->setDefaultDateFromString('', 'activeDate');

        $returnedDate = $this->task->getActiveDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetActiveDateString()
    {
        $expectedDate = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->task->getDateAsString('activeDate'));
        $this->task->setDateFromString($expectedDate, 'activeDate');

        $returnedDate = $this->task->getDateAsString('activeDate');

        $this->assertEquals(
            $expectedDate,
            $returnedDate
        );
    }

    public function testCreateInvalidDueDate()
    {
        $expectedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                '24/09/2013'
            );

        $expectedError = "The due date cannot be in the past";

        $this->task->setDueDate($expectedDate);
        $this->assertFalse($this->task->isValid(array('dueDate')));
        $errors = $this->task->getErrorMessages();
        $this->assertEquals($expectedError, $errors['errors']['dueDate']['callbackValue']);
    }

    public function testGetSetName()
    {
        $taskname = 'Test Name';

        $this->task->setName($taskname);

        $this->assertEquals(
            $taskname,
            $this->task->getName()
        );
    }

    public function testGetSetDescription()
    {
        $taskdesc = 'Test Description';

        $this->task->setDescription($taskdesc);

        $this->assertEquals(
            $taskdesc,
            $this->task->getDescription()
        );
    }

    public function testGetSetCreatedTime()
    {
        $expected = new \DateTime('2013-11-22T04:03:02');

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Task\Task',
            $this->task->setCreatedTime($expected)
        );

        $this->assertEquals(
            $expected,
            $this->task->getCreatedTime()
        );
    }

    public function testSetGetAssignedUser()
    {
        $name = 'Testuser';
        $user = new User();
        $user->setSurname($name);

        $this->assertFalse($this->task->isAssigned());
        $this->task->assign($user);

        $this->assertEquals(
            $name,
            $this->task->getAssignee()->getSurname()
        );
        $this->assertTrue($this->task->isAssigned());
    }

    public function testUnnasignUser()
    {
        $this->task->setAssignedUser();

        $this->assertTrue($this->task->getAssignedUser() instanceof NullEntity);
    }

    public function testValidations()
    {
        $expectedErrors = array(
            'errors' => array(
                'name'    => array(
                    'isEmpty' => "Value is required and can't be empty"
                ),
                'status'  => array(
                    'isEmpty' => "Value is required and can't be empty"
                ),
                'dueDate' => array(
                    'isEmpty' => "Value is required and can't be empty"
                ),
                'case'    => array(
                    'isEmpty' => "Value is required and can't be empty"
                )
            )
        );

        $this->assertFalse($this->task->isValid());
        $this->assertEquals($expectedErrors, $this->task->getErrorMessages());

        unset($expectedErrors['errors']['name']);
        $this->task->setName('Test Task');
        $this->assertFalse($this->task->isValid());
        $this->assertEquals($expectedErrors, $this->task->getErrorMessages());

        unset($expectedErrors['errors']['status']);
        $this->task->setStatus('Not Started');
        $this->assertFalse($this->task->isValid());
        $this->assertEquals($expectedErrors, $this->task->getErrorMessages());

        unset($expectedErrors['errors']['dueDate']);
        $this->task->setDueDate(new \DateTime('tomorrow'));
        $this->assertFalse($this->task->isValid());
        $this->assertEquals($expectedErrors, $this->task->getErrorMessages());

        unset($expectedErrors['errors']['case']);
        $this->task->setCase(new Lpa());
        $this->assertTrue($this->task->isValid());
    }

    public function testGetSetCase()
    {
        $case = new Lpa();

        $this->task->setCase($case);

        $this->assertEquals(
            $case,
            $this->task->getCase()
        );
    }

    public function testGetSetDueDateString()
    {
        $expected = date('d/m/Y');

        $this->task->setDateFromString($expected, 'dueDate');

        $this->assertEquals($expected, $this->task->getDateAsString('dueDate'));
    }

    public function testGetRagRatingGreen()
    {
        $expectedDueDate = date('d/m/Y', strtotime('+2 weeks'));
        $this->task->setDateFromString($expectedDueDate, 'dueDate');

        $this->assertEquals(1, $this->task->getRagRating());
    }

    public function testGetRagRatingRed()
    {
        $expectedDueDate = date('d/m/Y', strtotime('-2 weeks'));
        $this->task->setDateFromString($expectedDueDate, 'dueDate');

        $this->assertEquals(3, $this->task->getRagRating());
    }

    public function testGetRagRatingAmber()
    {
        $expectedDueDate = date('d/m/Y');
        $this->task->setDateFromString($expectedDueDate, 'dueDate');

        $this->assertEquals(2, $this->task->getRagRating());
    }

    public function testGetRagRatingError()
    {
        $this->assertEquals(3, $this->task->getRagRating());
    }

    public function testGetSetCompletedDateNulls()
    {
        $expectedDate = new \DateTime();
        $this->assertEmpty($this->task->getCompletedDate());
        $this->task->setCompletedDate();
        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->task->getCompletedDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetCompletedDateString()
    {
        $expected = date(OPGDateFormat::getDateTimeFormat());
        $this->task->setDateTimeFromString($expected, 'completedDate');
        $this->assertEquals($expected, $this->task->getDateTimeAsString('completedDate'));
    }


    public function testGetSetCompletedDateEmptyString()
    {
        $this->assertEmpty($this->task->getDateAsString('completedDate'));
        $expectedDate = new \DateTime();
        $this->task->setDefaultDateFromString('', 'completedDate');
        $returnedDate = $this->task->getCompletedDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateTimeFormat()),
            $returnedDate->format(OPGDateFormat::getDateTimeFormat())
        );
    }

    public function testSetCompletedDateIsSetWhenCaseStatusSetToCompleted()
    {
        $this->task->setStatus('completed');
        $this->assertNotEmpty($this->task->getCompletedDate());
        $this->assertEquals($this->task->getCompletedDate(), new \DateTime());
    }

    public function testClassConstantsExist()
    {
        $this->assertEquals(task::STATUS_COMPLETED,'completed');
    }

}
