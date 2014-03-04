<?php
namespace OpgTest\Common\Model\Entity;

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
}
