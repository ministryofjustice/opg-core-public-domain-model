<?php
namespace Opg\Core\Model\Entity\CaseItem;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemCollectionFilter;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

/**
 * Class CaseItemCollection
 *
 * @package Opg\Core\Model\Entity\CaseItem
 */
class CaseItemCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait {
        isValid as isValidTrait;
    }
    
    /**
     * @var array
     */
    private $caseItemCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * @param array $data
     *
     * @return CaseItemCollection
     */
    public function exchangeArray(array $data)
    {
        if (!empty($data['cases']) && is_array($data['cases'])) {
            foreach ($data['cases'] as $case) {
                $caseItem = new Lpa();
                $caseItem->setCaseId($case);
                $this->addCaseItem($caseItem);
            }
        }

        return $this;
    }

    /**
     * Alias for getCaseItemCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getCaseItemCollection();
    }

    /**
     * @return array
     */
    public function getCaseItemCollection()
    {
        return $this->caseItemCollection;
    }

    /**
     * @param CaseItemInterface $caseItem
     * @return CaseItemCollection
     */
    public function addCaseItem(CaseItemInterface $caseItem)
    {
        $this->caseItemCollection[] = $caseItem;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->caseItemCollection as $caseItem) {
            $results[] = $caseItem->toArray();
        }

        return $results;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $data = [];

        foreach ($this->caseItemCollection as $caseItem) {
            $data[] = $caseItem->getArrayCopy();
        }

        return $data;
    }

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new CaseItemCollectionFilter();
        }

        return $this->inputFilter;
    }

    /**
     * @param array $validations
     *
     * @return array
     */
    public function isValid(array $validations = null)
    {
        $validation = array();
        $validation[] = $this->isValidTrait();

        // @TODO should be moved to validation class (caseItemCollectionFilter)
        if (count($this->caseItemCollection) == 0) {
            return false;
        }

        foreach($this->caseItemCollection as $caseItem) {
            $validation[] = $caseItem->isValid($validations);
        }

        if (in_array(false, $validation)) {
            return false;
        }

        return true;
    }
}
