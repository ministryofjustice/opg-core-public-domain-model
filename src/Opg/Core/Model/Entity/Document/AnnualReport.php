<?php

namespace Opg\Core\Model\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\EntityInterface;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Exclude;
use Opg\Core\Model\Entity\Document\Decorators\AssetLog;
use Opg\Core\Model\Entity\Document\Decorators\HasAssetLog;
use Opg\Core\Model\Entity\Document\Validation\InputFilter\AnnualReportFilter;

/**
 * Class AnnualReport
 * @package Opg\Core\Model\Entity\Document
 *
 * @ORM\Entity
 */
class AnnualReport extends Document implements EntityInterface, HasAssetLog
{
    use AssetLog;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
     * @Groups({"api-person-get"})
     */
    protected $direction = self::DOCUMENT_INTERNAL_CORRESPONDENCE;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $reportingPeriod;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="dueDate")
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="revisedDueDate")
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $revisedDueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="receiptDate")
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $receiptDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lodgedDate")
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $lodgedDate;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $status;

    /**
     * @param \DateTime $dueDate
     * @return AnnualReport
     */
    public function setDueDate(\DateTime $dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $lodgedDate
     * @return AnnualReport
     */
    public function setLodgedDate(\DateTime $lodgedDate)
    {
        $this->lodgedDate = $lodgedDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLodgedDate()
    {
        return $this->lodgedDate;
    }

    /**
     * @param \DateTime $receiptDate
     * @return AnnualReport
     */
    public function setReceiptDate(\DateTime $receiptDate)
    {
        $this->receiptDate = $receiptDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReceiptDate()
    {
        return $this->receiptDate;
    }

    /**
     * @param string $reportingPeriod
     * @return AnnualReport
     */
    public function setReportingPeriod($reportingPeriod)
    {
        $this->reportingPeriod = $reportingPeriod;

        return $this;
    }

    /**
     * @return string
     */
    public function getReportingPeriod()
    {
        return $this->reportingPeriod;
    }

    /**
     * @param \DateTime $revisedDueDate
     * @return AnnualReport
     */
    public function setRevisedDueDate(\DateTime $revisedDueDate)
    {
        $this->revisedDueDate = $revisedDueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRevisedDueDate()
    {
        return $this->revisedDueDate;
    }

    /**
     * @param string $status
     * @return AnnualReport
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Retrieve input filter
     *
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        if (null === $this->inputFilter) {
            $this->inputFilter = new BaseInputFilter();
            $this->inputFilter->merge(new AnnualReportFilter());
        }

        return $this->inputFilter;
    }

    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }
}
