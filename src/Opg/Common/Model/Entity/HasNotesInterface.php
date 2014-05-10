<?php
namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Note\Note as NoteEntity;

/**
 * Interface HasNotesInterface
 * @package Opg\Common\Model\Entity
 */
interface HasNotesInterface
{

    /**
     * @return ArrayCollection|null
     */
    public function getNotes();

    /**
     * @param  ArrayCollection $notes
     *
     * @return ArrayCollection|null
     */
    public function setNotes(ArrayCollection $notes);

    /**
     * @param NoteEntity $note
     *
     * @return $this
     */
    public function addNote(NoteEntity $note);

    /**
     * @param ArrayCollection $notes
     *
     * @return $this
     */
    public function addNotes(ArrayCollection $notes);
}
