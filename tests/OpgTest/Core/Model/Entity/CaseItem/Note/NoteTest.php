<?php
namespace OpgTest\Core\Model\CaseItem\Note;

use Opg\Common\Exception\UnusedException;

use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\User\User;
use Zend\InputFilter\InputFilterAwareInterface;

/**
 * Note test case.
 */
class NoteTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Note
     */
    private $note;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->note = new Note();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->note = null;

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
        $id = 'Test ID';

        $this->note->setId($id);

        $this->assertEquals(
            $id,
            $this->note->getId()
        );
    }

    public function testGetSetName()
    {
        $notename = 'Test Name';

        $this->note->setName($notename);

        $this->assertEquals(
            $notename,
            $this->note->getName()
        );
    }

    public function testGetSetSourceId()
    {
        $sourceId = 123;

        $this->note->setSourceId($sourceId);

        $this->assertEquals(
            $sourceId,
            $this->note->getSourceId()
        );
    }

    public function testGetSetSourceTable()
    {
        $sourceTable = 'Test SourceTable';

        $this->note->setSourceTable($sourceTable);

        $this->assertEquals(
            $sourceTable,
            $this->note->getSourceTable()
        );
    }


    public function testGetSetStatus()
    {
        $status = 'Test Status';

        $this->note->setStatus($status);

        $this->assertEquals(
            $status,
            $this->note->getStatus()
        );
    }

    public function testGetSetDescription()
    {
        $description = 'Test Description';

        $this->note->setDescription($description);

        $this->assertEquals(
            $description,
            $this->note->getDescription()
        );
    }

    public function testGetSetCreatedTime()
    {
        $expected = '2013-11-22T04:03:02';

        $this->note->setCreatedTime($expected);

        $this->assertEquals(
            $expected,
            $this->note->getCreatedTime()
        );
    }

    public function testSetGetCreatedByUser()
    {
        $name = 'Testuser';
        $user = new User();
        $user->setFirstname($name);

        $this->note->setCreatedByUser($user);

        $this->assertEquals(
            $name,
            $this->note->getCreatedByUser()->getFirstname()
        );
    }

    public function testGetSetType()
    {
        $noteType = 'General Correspondance';
        $this->note->setType($noteType);

        $this->assertEquals(
            $noteType,
            $this->note->getType()
        );
    }

    public function testExchangeArray() {

        $expectedUser = new User();
        $expectedUserFirstName = 'Test';
        $expectedUserSurname   = 'User';
        $expectedUser->setFirstName($expectedUserFirstName)->setSurname($expectedUserSurname);


        $array = array(
            'id'            => 1,
            'type'          => 'General Note',
            'createdTime'   => '2013-11-22T04:03:02',
            'status'        => 'A',
            'description'   => 'Test Note Body',
            'name'          => 'Test Note Header',
            'user'          => $expectedUser->toArray()
        );

        $this->note->exchangeArray($array);

        $this->assertEquals(
            $array['id'],
            $this->note->getId()
        );

        $this->assertEquals(
            $array['type'],
            $this->note->getType()
        );

        $this->assertEquals(
            $array['createdTime'],
            $this->note->getCreatedTime()
        );

        $this->assertEquals(
            $array['status'],
            $this->note->getStatus()
        );

        $this->assertEquals(
            $array['description'],
            $this->note->getDescription()
        );

        $this->assertEquals(
            $array['name'],
            $this->note->getName()
        );

        $this->assertTrue($this->note->getCreatedByUser() instanceof User);

        $this->assertEquals(
            $expectedUserFirstName,
            $this->note->getCreatedByUser()->getFirstName()
        );
    }
}
