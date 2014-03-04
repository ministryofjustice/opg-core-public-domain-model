<?php
namespace OpgTest\Core\Model\CaseItem\Note;

use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\User\User;

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
        $user->setRealname($name);
    
        $this->note->setCreatedByUser($user);
    
        $this->assertEquals(
            $name,
            $this->note->getCreatedByUser()->getRealname()
        );
    }
}
