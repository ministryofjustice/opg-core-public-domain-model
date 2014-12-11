<?php
namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Note\Note as NoteEntity;

/**
 * Interface HasNotesInterface
 * @package Opg\Common\Model\Entity
 */
interface HasNotesInterface
{

    /**
     * @return ArrayCollection
     */
    public function getNotes();

    /**
     * @param  ArrayCollection $notes
     * @return HasNotesInterface
     */
    public function setNotes(ArrayCollection $notes);

    /**
     * @param NoteEntity $note
     * @return HasNotesInterface
     */
    public function addNote(NoteEntity $note);

    /**
     * @param ArrayCollection $notes
     * @return HasNotesInterface
     */
    public function addNotes(ArrayCollection $notes);

    /**
     * @param NoteEntity $note
     * @return boolean
     */
    public function hasNote(NoteEntity $note);

    /**
     * @param NoteEntity $note
     * @return HasNotesInterface
     */
    public function removeNote(NoteEntity $note);
}
