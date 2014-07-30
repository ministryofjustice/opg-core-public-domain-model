<?php
namespace OpgTest\Core\Model\Entity;

use Opg\Core\Model\Entity\Queue;

/**
 * Queue test case.
 */
class QueueTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Queue
     */
    private $queue;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->queue = new Queue();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->queue = null;

        parent::tearDown();
    }

    public function testSetGetId()
    {
        $id = 123;

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setId( $id )
        );

        $this->assertEquals( $id, $this->queue->getId() );
    }

    public function testSetGetQueue()
    {
        $queue = 'testqueue';

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setQueue( $queue )
        );

        $this->assertEquals( $queue, $this->queue->getQueue() );
    }

    public function testSetGetData()
    {
        $data = 'testdata';

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setData( $data )
        );

        $this->assertEquals( $data, $this->queue->getData() );
    }

    public function testSetGetStatus()
    {
        $status = 123;

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setStatus( $status )
        );

        $this->assertEquals( $status, $this->queue->getStatus() );
    }

    public function testSetGetCreated()
    {
        $created = new \DateTime();

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setCreated( $created )
        );

        $this->assertEquals( $created, $this->queue->getCreated() );
    }

    public function testSetGetScheduled()
    {
        $scheduled = new \DateTime();

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setScheduled( $scheduled )
        );

        $this->assertEquals( $scheduled, $this->queue->getScheduled() );
    }

    public function testSetGetExecuted()
    {
        $executed = new \DateTime();

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setExecuted( $executed )
        );

        $this->assertEquals( $executed, $this->queue->getExecuted() );
    }

    public function testSetGetFinished()
    {
        $finished = new \DateTime();

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setFinished( $finished )
        );

        $this->assertEquals( $finished, $this->queue->getFinished() );
    }

    public function testSetMessage()
    {
        $message = 'test message';

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setMessage( $message )
        );

        $this->assertEquals( $message, $this->queue->getMessage() );
    }

    public function testSetTrace()
    {
        $trace = 'test trace';

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Queue',
            $this->queue->setTrace( $trace )
        );

        $this->assertEquals( $trace, $this->queue->getTrace() );
    }
}
