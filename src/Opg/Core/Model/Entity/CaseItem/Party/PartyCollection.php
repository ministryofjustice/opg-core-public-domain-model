<?php

namespace Opg\Core\Model\Entity\CaseItem\Party;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class PartyCollection
 *
 * @package Opg Core
 */
class PartyCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;

    /**
     * @var array
     */
    private $partyCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getPartyCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getPartyCollection();
    }

    /**
     * @return array
     */
    public function getPartyCollection()
    {
        return $this->partyCollection;
    }

    /**
     * @param PartyInterface $party
     * @return PartyCollection
     */
    public function addParty(PartyInterface $party)
    {
        $this->partyCollection[] = $party;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->partyCollection as $party) {
            $results[] = $party->toArray();
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
