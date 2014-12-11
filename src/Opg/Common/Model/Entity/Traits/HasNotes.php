<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Core\Model\Entity\Note\Note as NoteEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class HasNotes
 *
 * Companion trait to the HasNotesInterface
 *
 * Note that this trait does not define "protected $notes;"
 * This is because each class which implements HasNotesInterface requires it's
 * own doctrine annotation to define the join table.
 * You will also need to initialise $notes to be an empty ArrayCollection in your constructor.
 *s See the Person or CaseItem objects for examples.
 *
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasNotes
{
    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\Note\Note", cascade={"persist"})
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @ReadOnly
     * @Groups({"api-person-get"})
     */
    protected $notes;

    protected function initNotes()
    {
        if (null === $this->notes) {
            $this->notes = new ArrayCollection();
        }
    }
    /**
     * @return ArrayCollection
     */
    public function getNotes()
    {
        $this->initNotes();

        return $this->notes;
    }

    /**
     * @param  ArrayCollection $notes
     *
     * @return HasNotesInterface
     */
    public function setNotes(ArrayCollection $notes)
    {
        $this->notes = new ArrayCollection();

        foreach($notes as $note) {
            $this->addNote($note);
        }

        return $this;
    }

    /**
     * @param NoteEntity $note
     *
     * @return HasNotesInterface
     */
    public function addNote(NoteEntity $note)
    {
        $this->initNotes();

        if (false === $this->notes->contains($note)) {
            $this->notes->add($note);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $notes
     *
     * @return HasNotesInterface
     */
    public function addNotes(ArrayCollection $notes)
    {
        foreach ($notes as $note) {
            $this->addNote($note);
        }

        return $this;
    }

    /**
     * @param NoteEntity $note
     * @return bool
     */
    public function hasNote(NoteEntity $note)
    {
        $this->initNotes();

        return $this->notes->contains($note);
    }

    /**
     * @param NoteEntity $note
     * @return HasNotesInterface
     */
    public function removeNote(NoteEntity $note)
    {
        if ($this->hasNote($note)) {
            $this->notes->removeElement($note);
        }

        return $this;
    }
}
