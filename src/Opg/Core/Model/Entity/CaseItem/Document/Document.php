<?php
namespace Opg\Core\Model\Entity\CaseItem\Document;

use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\CaseItem\Page\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;


/**
 * @ORM\Entity
 * @ORM\Table(name = "documents")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Document
 * @package Opg\Core\Model\Entity\CaseItem\Document
 */
class Document implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use \Opg\Common\Model\Entity\Traits\ToArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string
     */
    protected $filename;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $type;

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
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $title;

    /**
     * @ORM\OneToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Page\Page", mappedBy = "document", indexBy = "pageNumber", cascade={"persist"})
     * @ORM\OrderBy({"pageNumber" = "ASC"})
     *
     * @var ArrayCollection
     * @ReadOnly
     */
    protected $pages;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @ReadOnly
     * @Accessor(getter="getCreatedDateString")
     */
    protected $createdDate;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->setCreatedDate();
    }

    /**
     * Fulfil IteratorAggregate interface requirements
     *
     * @return \RecursiveArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
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
     * @param string $id
     *
     * @return Document
     */
    public function setId($id)
    {
        $this->id = (int)$id;

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
     * @return Document
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
     * @param string $title
     *
     * @return Document
     */
    public function setTitle($title)
    {
        $this->title = (string)$title;

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
        $this->type = (string)$type;

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
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return Document
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param \DateTime $createdDate
     * @return $this
     */
    public function setCreatedDate(\DateTime $createdDate = null)
    {
        if (null === $createdDate) {
            $this->createdDate = new \DateTime();
        } else {
            $this->createdDate = $createdDate;
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return string
     */
    public function getCreatedDateString()
    {
        if (null !== $this->createdDate) {
            return $this->createdDate->format(OPGDateFormat::getDateTimeFormat());
        }

        return '';
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
     * @return $this
     */
    public function setSourceDocumentType($sourceDocumentType)
    {
        $this->sourceDocumentType = (string)$sourceDocumentType;

        return $this;
    }
}
