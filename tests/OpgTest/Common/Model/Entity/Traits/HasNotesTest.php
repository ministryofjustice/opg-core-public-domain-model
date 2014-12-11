<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\Traits\HasNotes as HasNotesTrait;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Core\Model\Entity\Note\Note as NoteEntity;

/**
 * HasNotes trait test.
 */

class NotesStub implements HasNotesInterface {
    use HasNotes;

    public function __unset($element) {
        if (property_exists(get_class($this), $element)) {
            $this->{$element} = null;
        }
    }
}

class HasNotesTest extends \PHPUnit_Framework_TestCase
{

    /** @var  NotesStub */
    protected $notes;

    public function setUp()
    {
        $this->notes = new NotesStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->notes instanceof HasNotesInterface);
        unset($this->notes->{'notes'});
        $this->assertTrue($this->notes->getNotes() instanceof ArrayCollection);
    }

    public function testHasNotes()
    {
        $note = new NoteEntity();
        $note->setId(1);

        $this->notes->addNote($note);

        $this->assertTrue($this->notes->hasNote($note));
    }

    public function testSetNotes()
    {
        $note1 = new NoteEntity();
        $note1->setId(1);

        $note2 = new NoteEntity();
        $note2->setId(2);

        $note3 = new NoteEntity();
        $note3->setId(3);

        $notes = new ArrayCollection();
        $notes->add($note1);
        $notes->add($note2);
        $notes->add($note3);

        $this->notes->setNotes($notes);

        $this->assertEquals($notes->toArray(), $this->notes->getNotes()->toArray());
    }

    public function testAddNotes()
    {
        $collection1 = new ArrayCollection();
        $collection2 = new ArrayCollection();

        for ( $i=1;$i<=5;$i++) {
            $collection1->add((new NoteEntity())->setId($i));
        }

        for (
            $i=10;$i<15;$i++) {
            $collection2->add((new NoteEntity())->setId($i));
        }

        $this->notes->setNotes($collection1);
        $this->notes->addNotes($collection2);

        $this->assertCount(10, $this->notes->getNotes()->toArray());
    }

    public function testRemoveNotes()
    {
        $note1 = new NoteEntity();
        $note1->setId(1);

        $note2 = new NoteEntity();
        $note2->setId(2);

        $note3 = new NoteEntity();
        $note3->setId(3);

        $notes = new ArrayCollection();
        $notes->add($note1);
        $notes->add($note2);
        $notes->add($note3);

        $this->notes->setNotes($notes);

        $this->notes->removeNote($note1);
        $this->assertNotContains($note1, $this->notes->getNotes()->toArray());
    }
}
