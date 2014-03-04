<?php

namespace Opg\Core\Model\Entity\CaseItem\Document;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;

/**
 * Class DocumentCollection
 *
 * @package Opg Core
 */
class DocumentCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;

    /**
     * @var array
     */
    private $documentCollection = array();

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getDocumentCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getDocumentCollection();
    }

    /**
     * @return array
     */
    public function getDocumentCollection()
    {
        return $this->documentCollection;
    }

    /**
     * @param Document $document
     * @return DocumentCollection
     */
    public function addDocument(Document $document)
    {
        $this->documentCollection[] = $document;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->documentCollection as $document) {
            $results[] = $document->toArray();
        }

        return $results;
    }
    
    public function exchangeArray(array $data)
    {
        throw new UnusedException();
    }
}
