<?php
namespace Opg\Core\Model\Entity\CaseItem\Page;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ORM\Entity
 * @ORM\Table(name = "document_pages")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * Class Page
 * @package Opg\Core\Model\Entity\CaseItem\Page
 */
class Page implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use ToArray;
    use ExchangeArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var string
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity = "Opg\Core\Model\Entity\CaseItem\Document\Document", inversedBy = "pages")
     * @var
     */
    private $document;

    /**
     * @ORM\Column(type = "integer")
     * @var int
     */
    private $pageNumber;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    private $thumbnail;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string
     */
    private $main;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string
     */
    private $text;

    public function setDocument(Document $document)
    {
        if ($this->document !== null) {
            throw new \LogicException("Document can only be set once.");
        }

        $this->document = $document;
    }

    public function getDocument()
    {
        return $this->document;
    }

    // Fulfil IteratorAggregate interface requirements
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
     * @param string $main
     *
     * @return Page
     */
    public function setMain($main)
    {
        $this->main = (string)$main;

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
        $this->pageNumber = (int)$pageNumber;

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
        $this->thumbnail = (string)$thumbnail;

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
     *
     * @return Page
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
