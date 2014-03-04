<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Task;

use Opg\Core\Model\Entity\CaseItem\Task\TaskCollection;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\User\User;

/**
 * Task test case.
 */
class TaskCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var TaskCollection
     */
    private $taskCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
                
        $this->taskCollection = new TaskCollection();
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

    public function testReturnsEmptyArrayWhenNoTasksAdded()
    {
        $expected = [];
        $actual = $this->taskCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $task = new Task();
            $task->setId($i);
            
            $user = new User();
            $user->setRealname('Testname');
            $task->setAssignedUser($user);
    
            $this->taskCollection->addTask(
                $task
            );
        }
    }

    public function testGetDataAlias()
    {
        $this->populateCollection();
    
        $this->assertEquals(
            $this->taskCollection->getData(),
            $this->taskCollection->getTaskCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->taskCollection->toArray();
    
        $expected = 10;
        $actual = count($array);
    
        $this->assertEquals(
            $expected,
            $actual
        );
    
        for ($i=0; $i<10; $i++) {
            $this->assertEquals(
                $i,
                $array[$i]['id']
            );
        }
    }
    
    public function testGetIterator()
    {
        $iterator = $this->taskCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->taskCollection->exchangeArray([]);
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->taskCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }


    public function testSortByDueDate() {
        $task1 = new Task();
        $task1->setDueDate("2013-01-01T00:00:00");

        $task2 = new Task();
        $task2->setDueDate("2015-01-01T00:00:00");

        $task3 = new Task();
        $task3->setDueDate("2014-01-01T00:00:00");

        $this->taskCollection
            ->addTask($task1)
            ->addTask($task2)
            ->addTask($task3);

        $unsortedTaskArray = $this->taskCollection->getData();

        // Verify the tasks are in insertion order
        $this->assertEquals($task1, $unsortedTaskArray[0]);
        $this->assertEquals($task2, $unsortedTaskArray[1]);
        $this->assertEquals($task3, $unsortedTaskArray[2]);

        $sortedTaskArray = $this->taskCollection
            ->sortByDueDate()
            ->getData();

        // Verify the notes are in due date order, ascending
        $this->assertEquals($task1, $sortedTaskArray[0]);
        $this->assertEquals($task3, $sortedTaskArray[1]);
        $this->assertEquals($task2, $sortedTaskArray[2]);
    }
}
