<?php

namespace Opg\Core\Model\Entity\LineItem;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Core\Model\Entity\Document\Document;

/**
 * Class LineItem
 * @package Opg\Core\Model\Entity\LineItem
 *
 * @ORM\Entity
 */
class LineItem implements HasIdInterface
{
    use HasId;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\Document\Document", cascade={"all"}, fetch="EAGER")
     * @Type("Opg\Core\Model\Entity\Document\Document")
     * @var \Opg\Core\Model\Entity\Document\Document
     */
    protected $document;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $itemName;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    protected $itemValue;

    /**
     * @param \Opg\Core\Model\Entity\Document\Document $document
     * @return LineItem
     */
    public function setDocument(Document $document)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\Document\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param string $itemName
     * @return LineItem
     */
    public function setName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->itemName;
    }

    /**
     * @param float $itemValue
     * @return LineItem
     */
    public function setValue($itemValue)
    {
        $this->itemValue = (float)$itemValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->itemValue;
    }
}
