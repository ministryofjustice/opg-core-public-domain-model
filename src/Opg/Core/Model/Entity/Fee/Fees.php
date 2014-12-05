<?php

namespace Opg\Core\Model\Entity\Fee;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\HasIdInterface;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Exclude;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\Traits\HasId;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * Class Fees
 * @package Opg\Core\Model\Entity\Fee
 *
 *  @ORM\Entity(repositoryClass="Application\Model\Repository\PaymentRepository")
 * @ORM\Table(name = "fees")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "deputyship_fees" = "Opg\Core\Model\Entity\Fee\DeputyshipFees",
 * })
 */
abstract class Fees
    implements HasIdInterface, HasDateTimeAccessor, EntityInterface, \IteratorAggregate
{
    use HasId;
    use DateTimeAccessor;
    use ToArray;
    use InputFilter;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("String")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="feePeriod")
     */
    protected $feePeriod;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("String")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="invoiceDate")
     */
    protected $invoiceDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $invoiceNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $feeCode;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    protected $feeValue = 0;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $feeStatus;

    /**
     * @param string $feeCode
     * @return Fees
     */
    public function setFeeCode($feeCode)
    {
        $this->feeCode = $feeCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeeCode()
    {
        return $this->feeCode;
    }

    /**
     * @param \DateTime $feePeriod
     * @return Fees
     */
    public function setFeePeriod(\DateTime $feePeriod)
    {
        $this->feePeriod = $feePeriod;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFeePeriod()
    {
        return $this->feePeriod;
    }

    /**
     * @param string $feeStatus
     * @return Fees
     */
    public function setFeeStatus($feeStatus)
    {
        $this->feeStatus = $feeStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeeStatus()
    {
        return $this->feeStatus;
    }

    /**
     * @param float $feeValue
     * @return Fees
     */
    public function setFeeValue($feeValue)
    {
        $this->feeValue = (float)$feeValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getFeeValue()
    {
        return $this->feeValue;
    }

    /**
     * @param \DateTime $invoiceDate
     * @return Fees
     */
    public function setInvoiceDate(\DateTime $invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param string $invoiceNumber
     * @return Fees
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new BaseInputFilter();
        }
        return $this->inputFilter;
    }

    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }
}
