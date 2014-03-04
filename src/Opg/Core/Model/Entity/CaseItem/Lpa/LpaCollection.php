<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class LpaCollection
 *
 * @deprecated
 * @package Opg\Core\Model\Entity\Lpa
 */
class LpaCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $lpaCollection = array();

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
     * @return $this|\Opg\Common\Model\Entity\CollectionInterface
     */
    public function exchangeArray(array $data)
    {
        if (!empty($data['cases']) && is_array($data['cases'])) {
            foreach ($data['cases'] as $case) {
                $lpa = new Lpa();
                $lpa->setCaseId($case);
                $this->addLpa($lpa);
            }
        }

        return $this;
    }

    /**
     * Alias for getLpaCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getLpaCollection();
    }

    /**
     * @return array
     */
    public function getLpaCollection()
    {
        return $this->lpaCollection;
    }

    /**
     * @param Lpa $lpa
     * @return LpaCollection
     */
    public function addLpa(Lpa $lpa)
    {
        $this->lpaCollection[] = $lpa;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->lpaCollection as $lpa) {
            $results[] = $lpa->getArrayCopy();
        }

        return $results;
    }
    
    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $data = get_object_vars($this);
    
        return $data;
    }
    
    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        return new InputFilter();
    }
}
