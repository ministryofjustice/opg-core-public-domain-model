<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class CertificateProviderCollection
 *
 * @package Opg Core
 */
class CertificateProviderCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $certificateProviderCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getCertificateProviderCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getCertificateProviderCollection();
    }

    /**
     * @return array
     */
    public function getCertificateProviderCollection()
    {
        return $this->certificateProviderCollection;
    }

    /**
     * @param CertificateProvider $certificateProvider
     * @return CertificateProviderCollection
     */
    public function addCertificateProvider(CertificateProvider $certificateProvider)
    {
        $this->certificateProviderCollection[] = $certificateProvider;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->certificateProviderCollection as $certificateProvider) {
            $results[] = $certificateProvider->toArray();
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
