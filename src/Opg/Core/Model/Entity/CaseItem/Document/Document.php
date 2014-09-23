<?php
namespace Opg\Core\Model\Entity\CaseItem\Document;


use Opg\Core\Model\Entity\CaseItem\Page\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Correspondence\BaseCorrespondence;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
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
 * @ORM\EntityListeners({"BusinessRule\Specification\Document\Listener"})
 *
 * Class Document
 * @package Opg\Core\Model\Entity\CaseItem\Document
 */
class Document extends BaseCorrespondence
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
     * @ORM\Column(type="integer")
     * @var int
     * @Accessor(getter="getDirection", setter="setDirection")
     */
    protected $direction = self::DOCUMENT_INCOMING_CORRESPONDENCE;

    /**
     * Non persisted entity
     * @var int
     * @Type("integer")
     * @ReadOnly
     * @Exclude
     */
    protected $caseId;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
        $this->setCreatedDate();
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

    /**
     * @param string $description
     * @return Document
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

    /**
     * @param $caseId
     * @return $this
     */
    public function setCaseId($caseId)
    {
        $this->caseId = (int) $caseId;

        return $this;
    }

    /**
     * @return int
     */
    public function getCaseId()
    {
        return $this->caseId;
    }

}
