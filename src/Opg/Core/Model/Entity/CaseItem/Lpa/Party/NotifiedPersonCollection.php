<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class NotifiedPersonCollection
 *
 * @package Opg Core
 */
class NotifiedPersonCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $notifiedPersonCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getNotifiedPersonCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getNotifiedPersonCollection();
    }

    /**
     * @return array
     */
    public function getNotifiedPersonCollection()
    {
        return $this->notifiedPersonCollection;
    }

    /**
     * @param NotifiedPerson $notifiedPerson
     * @return NotifiedPersonCollection
     */
    public function addNotifiedPerson(NotifiedPerson $notifiedPerson)
    {
        $this->notifiedPersonCollection[] = $notifiedPerson;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->notifiedPersonCollection as $notifiedPerson) {
            $results[] = $notifiedPerson->toArray();
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
}
