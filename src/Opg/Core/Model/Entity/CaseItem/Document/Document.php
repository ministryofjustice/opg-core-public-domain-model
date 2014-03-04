<?php
namespace Opg\Core\Model\Entity\CaseItem\Document;

use Opg\Core\Model\Entity\CaseItem\Page\PageCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\EntityInterface;

/**
 * Class Document
 * @package Opg\Core\Model\Entity\CaseItem\Document
 */
class Document implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use \Opg\Common\Model\Entity\Traits\ToArray;
    
    /**
     * @var string
     */
    private $id;
    
    /**
     * @var string
     */
    private $filename;
    
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $subtype;

    /**
     * @var string
     */
    private $title;

    /**
     * @var PageCollection
     */
    private $pages;
    
    public function toArray()
    {
        $data = get_object_vars($this);

        $numberOfPages = 0;
        
        $pages = array();
        if (!empty($this->pages)) {
            foreach($this->getPageCollection()->getData() as $page) {
                $pages[] = $page->toArray();
                $numberOfPages ++;
            }
            $data['pages'] = $pages;
        }

        unset($data['inputFilter']);
    
        $data['metadata'] = [];
        
        $data['metadata']['filename'] = $data['filename'];
        unset($data['filename']);
        
        $data['metadata']['documentType'] = $data['type'];
        $data['metadata']['numberOfPages'] = $numberOfPages;
        
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

        if (!empty($data['type'])) {
            $this->setType($data['type']);
        }

        if (!empty($data['subtype'])) {
            $this->setSubType($data['subtype']);
        }

        if (!empty($data['title'])) {
            $this->setTitle($data['title']);
        }
        
        if (!empty($data['metadata'])) {
            $metadata = $data['metadata'];
            if (!empty($data['metadata']['filename'])) {
                $this->setFilename($metadata['filename']);
            }
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
    
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'id',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 5,
                                    'max'      => 48,
                                ),
                            )
                        )
                    )
                )
            );
    
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }

    /**
     *  @param string $id
     *
     * @return Document
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
     * @param \Opg\Core\Model\Entity\CaseItem\Page\PageCollection $pages
     *
     * @return Document
     */
    public function setPageCollection(PageCollection $pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\Page\PageCollection
     */
    public function getPageCollection()
    {
        return $this->pages;
    }

    /**
     * @param string $subtype
     *
     * @return Document
     */
    public function setSubtype($subtype)
    {
        $this->subtype = (string) $subtype;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * @param string $title
     *
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $type
     *
     * @return Document
     */
    public function setType($type)
    {
        $this->type = (string) $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
	/**
     * @return the $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

	/**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
}
