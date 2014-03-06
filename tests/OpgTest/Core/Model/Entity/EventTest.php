<?php
namespace OpgTest\Core\Model\Entity\Event;

use Opg\Core\Model\Entity\Event;
use Opg\Core\Model\Entity\User\User;

/**
 * Event test case.
 */
class EventTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Event
     */
    private $event;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->event = new Event();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->event = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testGetSetId()
    {
        $id = 123;

        $this->event->setId($id);

        $this->assertEquals(
            $id,
            $this->event->getId()
        );
    }

    public function testGetSetSourceId()
    {
        $sourceId = 123;

        $this->event->setSourceEntityId($sourceId);

        $this->assertEquals(
            $sourceId,
            $this->event->getSourceEntityId()
        );
    }

    public function testGetSetSourceTable()
    {
        $sourceTable = 'Test SourceTable';

        $this->event->setSourceTable($sourceTable);

        $this->assertEquals(
            $sourceTable,
            $this->event->getSourceTable()
        );
    }

    public function testGetSetCreatedOn()
    {
        $expected = new \DateTime();

        $this->event->setCreatedOn($expected);

        $this->assertEquals(
            $expected,
            $this->event->getCreatedOn()
        );
    }

    public function testSetGetCreatedByUser()
    {
        $name = 'Testuser';
        $user = new User();
        $user->setFirstname($name);

        $this->event->setUser($user);

        $this->assertEquals(
            $name,
            $this->event->getUser()->getFirstname()
        );
    }

    public function testGetSetType()
    {
        $eventType = 'READ';
        $this->event->setType($eventType);

        $this->assertEquals(
            $eventType,
            $this->event->getType()
        );
    }

    public function testToArrayExchangeArray()
    {
        $user = new User();
        $user->setId(111)
            ->setFirstname('Test Firstname')
            ->setSurname('Test Surname');

        $event = $this->event->setId(123)
            ->setSourceEntityId(456)
            ->setSourceTable('table1')
            ->setUser($user)
            ->setType('READ')
            ->setCreatedOn(new \DateTime());

        $eventToArray = $this->event->toArray();

        $this->assertSame($event, $this->event->exchangeArray($eventToArray));
    }

    /**
     * @expectedException \Exception
     */
    public function testGetInputFilter()
    {
        $this->event->getInputFilter();
    }
}
