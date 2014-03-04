<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Note;

use Opg\Core\Model\Entity\CaseItem\Note\NoteCollection;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\User\User;

/**
 * Note test case.
 */
class NoteCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var NoteCollection
     */
    private $noteCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
                
        $this->noteCollection = new NoteCollection();
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

    public function testReturnsEmptyArrayWhenNoNotesAdded()
    {
        $expected = [];
        $actual = $this->noteCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $note = new Note();
            $note->setId($i);
            $user = new User();
            $user->setRealname('Testname');
            $note->setCreatedByUser($user);

            $this->noteCollection->addNote(
                $note
            );
        }
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
    
        $this->assertEquals(
            $this->noteCollection->getData(),
            $this->noteCollection->getNoteCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->noteCollection->toArray();
    
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
        $iterator = $this->noteCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->noteCollection->exchangeArray([]);
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->noteCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }

    public function testSortByCreatedDateDesc() {
        $note1 = new Note();
        $note1->setCreatedTime("2013-01-01T00:00:00");

        $note2 = new Note();
        $note2->setCreatedTime("2015-01-01T00:00:00");

        $note3 = new Note();
        $note3->setCreatedTime("2014-01-01T00:00:00");

        $this->noteCollection
            ->addNote($note1)
            ->addNote($note2)
            ->addNote($note3);

        $unsortedNoteArray = $this->noteCollection->getData();

        // Verify the notes are in insertion order
        $this->assertEquals($note1, $unsortedNoteArray[0]);
        $this->assertEquals($note2, $unsortedNoteArray[1]);
        $this->assertEquals($note3, $unsortedNoteArray[2]);

        $sortedNoteArray = $this->noteCollection
            ->sortByCreatedDateDesc()
            ->getData();

        // Verify the notes are in created date order, descending
        $this->assertEquals($note2, $sortedNoteArray[0]);
        $this->assertEquals($note3, $sortedNoteArray[1]);
        $this->assertEquals($note1, $sortedNoteArray[2]);
    }
}
