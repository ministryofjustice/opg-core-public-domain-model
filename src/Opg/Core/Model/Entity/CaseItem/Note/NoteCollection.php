<?php
namespace Opg\Core\Model\Entity\CaseItem\Note;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class NoteCollection
 *
 * @package Opg Core
 */
class NoteCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $noteCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getNoteCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getNoteCollection();
    }

    /**
     * @return array
     */
    public function getNoteCollection()
    {
        return $this->noteCollection;
    }

    /**
     * @param Note $note
     * @return NoteCollection
     */
    public function addNote(Note $note)
    {
        $this->noteCollection[] = $note;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->noteCollection as $note) {
            $results[] = $note->getArrayCopy();
        }

        return $results;
    }
    
    public function exchangeArray(array $data)
    {
        throw new UnusedException();
    }
    
    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        return new InputFilter();
    }

    /**
     * @return NoteCollection
     */
    public function sortByCreatedDateDesc() {
        // @TODO remove the @ operator.
        // Please do not remove the @ symbol until this PHP bug is fixed:
        // https://bugs.php.net/bug.php?id=50688
        @usort($this->noteCollection, function(Note $a, Note $b) {
                // The -1 and 1 are deliberately the wrong way around because this is a DESCENDING sort.
                if ($a->getCreatedTime() < $b->getCreatedTime()) { return 1; }
                if ($a->getCreatedTime() > $b->getCreatedTime()) { return -1; }
                return 0;
            });

        return $this;
    }
}
