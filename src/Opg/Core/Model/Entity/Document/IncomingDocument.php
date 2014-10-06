<?php
namespace Opg\Core\Model\Entity\Document;

use Opg\Core\Model\Entity\CaseItem\Page\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"BusinessRule\Specification\Document\Listener"})
 *
 * Class Document
 * @package Opg\Core\Model\Entity\Document
 */
class IncomingDocument extends Document
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $subtype;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $sourceDocumentType;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Page\Page", mappedBy = "document", indexBy = "pageNumber", cascade={"persist"})
     * @ORM\OrderBy({"pageNumber" = "ASC"})
     *
     * @var ArrayCollection
     * @ReadOnly
     */
    protected $pages;

    /**
     * @Accessor(getter="getDirection")
     * @ReadOnly
     */
    protected $direction = self::DOCUMENT_INCOMING_CORRESPONDENCE;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->setCreatedDate();
    }

    /**
     * @return InputFilter
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
                                'name' => 'Digits'
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
     * @param ArrayCollection $pages
     *
     * @return Document
     */
    public function setPages(ArrayCollection $pages)
    {
        foreach ($pages as $page) {
            $this->addPage($page);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Page $page
     *
     * @return Document
     */
    public function addPage(Page $page)
    {
        $nextPageNumber = count($this->pages) + 1;
        $page->setPageNumber($nextPageNumber);
        $page->setDocument($this);

        $this->pages->set($nextPageNumber, $page);

        return $this;
    }

    /**
     * @param string $subtype
     *
     * @return IncomingDocument
     */
    public function setSubtype($subtype)
    {
        $this->subtype = (string)$subtype;

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
     * @return string
     */
    public function getSourceDocumentType()
    {
        return $this->sourceDocumentType;
    }

    /**
     * @param $sourceDocumentType
     * @return IncomingDocument
     */
    public function setSourceDocumentType($sourceDocumentType)
    {
        $this->sourceDocumentType = (string)$sourceDocumentType;

        return $this;
    }

    /**
     * @param string $description
     * @return IncomingDocument
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
