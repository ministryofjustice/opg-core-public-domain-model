<?php
namespace Opg\Core\Model\Entity\CaseItem\Page;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\EntityInterface;

/**
 * Class Page
 * @package Opg\Core\Model\Entity\CaseItem\Page
 */
class Page implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\InputFilter;

    /**
     * @var string
     */
    private $id;

    /**
     * @var int
     */
    private $pageNumber;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var string
     */
    private $main;
    
    /**
     * @var string
     */
    private $text;

    /**
     * Instead of using the ToArray trait, we have a custom one
     * which adds a metadata structure
     * 
     * @return array
     */
    public function toArray()
    {
        $data = get_object_vars($this);
        unset($data['inputFilter']);
        
        return $data;
    }

    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * @param array $data
     *
     * @return EntityInterface|void
     */
    public function exchangeArray(array $data)
    {
        if (!empty($data['id'])) {
            $this->setId($data['id']);
        }

        if (!empty($data['pageNumber'])) {
            $this->setPageNumber($data['pageNumber']);
        }

        if (!empty($data['thumbnail'])) {
            $this->setThumbnail($data['thumbnail']);
        }

        if (!empty($data['main'])) {
            $this->setMain($data['main']);
        }
        
        if (!empty($data['text'])) {
            $this->setText($data['text']);
        }
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
     * @param string $id
     *
     * @return Page
     */
    public function setId($id)
    {
        $this->id = (string) $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $main
     *
     * @return Page
     */
    public function setMain($main)
    {
        $this->main = (string) $main;

        return $this;
    }

    /**
     * @return string
     */
    public function getMain()
    {
        return $this->main;
    }

    /**
     * @param int $pageNumber
     *
     * @return Page
     */
    public function setPageNumber($pageNumber)
    {
        $this->pageNumber = (int) $pageNumber;

        return $this;
    }

    /**
     * @return int
     */
    public function getPageNumber()
    {
        return $this->pageNumber;
    }

    /**
     * @param string $thumbnail
     *
     * @return Page
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = (string) $thumbnail;

        return $this;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    
    /**
     * @param string $text
     * @return Page
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }
    
	/**
     * @return $text
     */
    public function getText()
    {
        return $this->text;
    }
}
