<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\HasNotes as HasNotesTrait;
use Opg\Core\Model\Entity\Note\Note as NoteEntity;

/**
 * HasNotes trait test.
 */
class HasNotesTest extends \PHPUnit_Framework_TestCase
{
    use HasNotesTrait;

    public function setUp()
    {
        $this->notes = new ArrayCollection();
    }

    public function testGetNotes()
    {
        $note = new NoteEntity();
        $note->setId(1);

        $this->notes->add($note);

        $this->assertSame($this->notes, $this->getNotes());
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

        $this->setNotes($notes);

        $this->assertSame($notes, $this->notes);
    }


    public function testAddNote()
    {
        $note1 = new NoteEntity();
        $note1->setId(1);

        $this->addNote($note1);

        $this->assertSame($note1, $this->notes->get(0));

        // Add a second note
        $note2 = new NoteEntity();
        $note2->setId(2);

        $this->addNote($note2);

        $this->assertSame($note1, $this->notes->get(0));
        $this->assertSame($note2, $this->notes->get(1));
    }


    public function testAddNotes()
    {
        $note1 = new NoteEntity();
        $note1->setId(1);

        $note2 = new NoteEntity();
        $note2->setId(2);

        $notesA = new ArrayCollection();
        $notesA->add($note1);
        $notesA->add($note2);

        $this->addNotes($notesA);

        $this->assertSame($note1, $this->notes->get(0));
        $this->assertSame($note2, $this->notes->get(1));

        // Add a second block of notes;
        $note3 = new NoteEntity();
        $note3->setId(4);

        $note4 = new NoteEntity();
        $note4->setId(4);

        $notesB = new ArrayCollection();
        $notesB->add($note3);
        $notesB->add($note4);

        $this->addNotes($notesB);

        $this->assertSame($note1, $this->notes->get(0));
        $this->assertSame($note2, $this->notes->get(1));
        $this->assertSame($note3, $this->notes->get(2));
        $this->assertSame($note4, $this->notes->get(3));
    }
}
