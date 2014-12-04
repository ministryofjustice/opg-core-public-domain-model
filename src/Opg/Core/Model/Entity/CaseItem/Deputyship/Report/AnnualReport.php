<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Report;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasDocumentsInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasDocuments;
use Opg\Common\Model\Entity\Traits\HasId;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Exclude;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Report\Validation\InputFilter\AnnualReportFilter;

/**
 * Class AnnualReport
 * @package Opg\Core\Model\Entity\CaseItem\Report
 *
 * @ORM\Entity
 */
class AnnualReport implements HasIdInterface, HasDocumentsInterface, EntityInterface, \IteratorAggregate
{
    use HasId;
    use HasDocuments;
    use InputFilter;
    use ToArray;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $reportingPeriod;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="dueDate")
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="revisedDueDate")
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $revisedDueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="receiptDate")
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $receiptDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lodgedDate")
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $lodgedDate;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $status;

    /**
     * None persisted entity
     * @var int
     * @ReadOnly
     * @Accessor(getter="getCorrespondenceCount")
     */
    protected $chaseCorrespondence;

    /**
     * @return int
     */
    public function getCorrespondenceCount()
    {
        return $this->getOutgoingDocuments()->count();
    }

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
