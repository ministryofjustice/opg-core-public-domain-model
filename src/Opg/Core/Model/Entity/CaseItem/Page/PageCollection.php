<?php
namespace Opg\Core\Model\Entity\CaseItem\Page;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;

/**
 * Class PageCollection
 *
 * @package Opg Core
 */
class PageCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;

    /**
     * @var array
     */
    private $pageCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

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
     * Alias for getPageCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getPageCollection();
    }

    /**
     * @return array
     */
    public function getPageCollection()
    {
        return $this->pageCollection;
    }

    /**
     * @param Page $page
     * @return PageCollection
     */
    public function addPage(Page $page)
    {
        $this->pageCollection[] = $page;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->pageCollection as $page) {
            $results[] = $page->toArray();
        }

        return $results;
    }

    public function exchangeArray(array $data)
    {
        throw new UnusedException();
    }
}
