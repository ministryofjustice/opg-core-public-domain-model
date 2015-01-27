<?php

namespace Opg\Core\Model\Entity\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Core\Model\Entity\Document\Decorators\ClosingBalances;
use Opg\Core\Model\Entity\Document\Decorators\HasClosingBalances;
use Opg\Core\Model\Entity\LineItem\LineItem;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Document
 */
class LodgingChecklist extends OutgoingDocument implements HasClosingBalances
{
    use ClosingBalances;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
     */
    protected $direction = self::DOCUMENT_INTERNAL_CORRESPONDENCE;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="startDate")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="endDate")
     */
    protected $endDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    protected $totalAssets;


    /**
     * @param \DateTime $startDate
     * @return LodgingChecklist
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $endDate
     * @return LodgingChecklist
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }


    /**
     * @param $totalAssets
     * @return LodgingChecklist
     */
    public function setTotalAssets($totalAssets)
    {
        $this->totalAssets = $totalAssets;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotalAssets()
    {
        return $this->totalAssets;
    }
}
