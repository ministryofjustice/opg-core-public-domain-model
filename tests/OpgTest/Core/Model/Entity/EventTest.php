<?php
namespace OpgTest\Core\Model\Entity\Event;

use Opg\Core\Model\Entity\Event;
use Opg\Core\Model\Entity\User\User;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->event->getCreatedOn());
        $this->assertEmpty($this->event->getCreatedOnString());

        $this->event->setCreatedOn($expectedDate);
        $this->assertEquals($expectedDate, $this->event->getCreatedOn());
    }

    public function testGetSetCreatedOnNulls()
    {
        $this->assertEmpty($this->event->getCreatedOn());
        $this->event->setCreatedOn();

        $this->assertEmpty($this->event->getCreatedOn());
    }

    public function testGetSetCreatedOnEmptyString()
    {
        $this->assertEmpty($this->event->getCreatedOnString());
        $this->event->setCreatedOnString('');
        $this->assertEmpty($this->event->getCreatedOnString());
    }

    public function testGetSetCreatedOnInvalidString()
    {
        $this->assertEmpty($this->event->getCreatedOnString());
        try {
            $this->event->setCreatedOnString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testGetSetCreatedOnString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->event->setCreatedOnString($expected);
        $this->assertEquals($expected, $this->event->getCreatedOnString());
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

    public function testGetEmptyChangeSet()
    {
        $this->assertFalse($this->event->hasChangeset());

        try {
            $this->event->getChangeset();
        }
        catch(\Exception $e) {
            $this->assertInstanceOf('\LogicException', $e);
        }
    }

    public function testCreateWithParams()
    {
        $owningEntityId = 1;
        $owningEntityClass = __CLASS__;
        $changeSet = array('id'=>'2');

        $this->event = new Event($owningEntityId, $owningEntityClass, $changeSet);

        $this->assertTrue($this->event->hasChangeset());

        $this->assertEquals($owningEntityId, $this->event->getOwningEntityId());
        $this->assertEquals($owningEntityClass, $this->event->getOwningEntityClass());

        $this->assertTrue(is_array($this->event->getChangeset()));
        $this->assertEquals($changeSet, $this->event->getChangeset());
    }

    public function testGetEntity()
    {
        $this->assertEmpty($this->event->getEntity());
    }
    public function testGetSourceEntityClass()
    {
        $this->assertEmpty($this->event->getSourceEntityClass());
    }

}
