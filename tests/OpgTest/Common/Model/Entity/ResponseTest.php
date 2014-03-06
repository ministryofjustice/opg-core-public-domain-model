<?php
namespace OpgTest\Common\Model\Entity;

use Opg\Core\Model\Entity\CaseItem\Task\Task;

use Opg\Common\Model\Entity\Response;

/**
 * Response test case.
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->search = null;

        parent::tearDown();
    }

    public function testSetGetData()
    {
        $response = new Response();
        $entityMock = \Mockery::mock('Opg\Common\Model\Entity\EntityInterface');

        $response->setData($entityMock);

        $this->assertEquals(
            $entityMock,
            $response->getData()
        );
    }

    public function testSetGetJsonData()
    {
        $response = new Response();

        $data = array(
            'item1', 'item2'
        );

        $response->setJsonData(
            json_encode($data)
        );

        $this->assertEquals($data, $response->getData());
    }

    public function testToArray()
    {
        $dataAsArray = ["Hello", "World"];

        $expected = [
            'data' => $dataAsArray
        ];

        $response = new Response();

        $entityMock = \Mockery::mock('Opg\Common\Model\Entity\EntityInterface');
        $entityMock->shouldReceive('toArray')
            ->andReturn($dataAsArray);

        $response->setData($entityMock);

        $this->assertEquals(
            $expected,
            $response->toArray()
        );
    }

    public function testExchangeArray() {
        $task = new Task();
        $taskArray = [
            'name'   => 'Test Task',
            'id'     => 123,
            'status' => 'very active'
        ];

        $task = $task->exchangeArray($taskArray);
        $dataArray = ['data' => $task];
        $response = new Response();

        $response = $response->exchangeArray($dataArray);

        $returnArray = $response->toArray();

        $this->assertEquals($returnArray['data']['name'], $taskArray['name']);
        $this->assertEquals($returnArray['data']['id'], $taskArray['id']);
        $this->assertEquals($returnArray['data']['status'], $taskArray['status']);
    }
}
