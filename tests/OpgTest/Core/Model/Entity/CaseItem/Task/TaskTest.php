<?php
namespace OpgTest\Core\Model\CaseItem\Task;

use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\User\User;

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
        'id'            => '123',
        'status'        => 'Registered',
        'name'          => 'Test name',
        'assignedUser'  => null,
        'priority'      => 'high',
        'dueDate'       => '2010-01-01',
        'createdTime'   => '2000-01-01T00:00:00',
        'errorMessages' => array(),
        'case'          => null
    );

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

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

        $this->task->exchangeArray($this->data);
        $this->assertEquals($this->data, $this->task->getIterator()->getArrayCopy());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->task->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);

    }

    public function testExchangeArray()
    {
        $user = new User();
        $user->setFirstname('Test User');
        $this->data['assignedUser'] = $user->toArray();
        $this->task->exchangeArray($this->data);

        $this->assertEquals($this->data, $this->task->toArray());
    }

    public function testGetSetId()
    {
        $id = 'Test ID';

        $this->task->setId($id);

        $this->assertEquals(
            $id,
            $this->task->getId()
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
        $expected = '2014-06-23';

        $this->task->setDueDate($expected);

        $this->assertEquals(
            $expected,
            $this->task->getDueDate()
        );
    }

    public function testCreateInvalidDueDate()
    {
        $expected       = '2013-09-24';
        $expectedError  = "The due date cannot be in the past";

        $this->task->setDueDate($expected);
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

    public function testGetSetCreatedTime()
    {
        $expected = '2013-11-22T04:03:02';

        $this->task->setCreatedTime($expected);

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

        $this->task->setAssignedUser($user);

        $this->assertEquals(
            $name,
            $this->task->getAssignedUser()->getSurname()
        );
    }

    public function testValidations()
    {
        $expectedErrors = array(
            'errors' => array(
                'name' => array(
                    'isEmpty' => "Value is required and can't be empty"
                ),
                'status' => array(
                        'isEmpty' => "Value is required and can't be empty"
                ),
                'dueDate' => array(
                    'isEmpty' => "Value is required and can't be empty"
                ),
                'case' => array(
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
        $this->task->setDueDate('2014-06-23');
        $this->assertFalse($this->task->isValid());
        $this->assertEquals($expectedErrors, $this->task->getErrorMessages());

        unset($expectedErrors['errors']['case']);
        $this->task->setCase(new Lpa());
        $this->assertTrue($this->task->isValid());
    }
}
