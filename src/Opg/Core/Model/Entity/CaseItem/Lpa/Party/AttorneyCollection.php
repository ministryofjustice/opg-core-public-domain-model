<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class AttorneyCollection
 *
 * @package Opg Core
 */
class AttorneyCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $attorneyCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getAttorneyCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getAttorneyCollection();
    }

    /**
     * @return array
     */
    public function getAttorneyCollection()
    {
        return $this->attorneyCollection;
    }

    /**
     * @param Attorney $attorney
     * @return AttorneyCollection
     */
    public function addAttorney(Attorney $attorney)
    {
        $this->attorneyCollection[] = $attorney;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->attorneyCollection as $attorney) {
            $results[] = $attorney->toArray();
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
