<?php


namespace Opg\Core\Model\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Common\Model\Entity\DateFormat;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Validation\InputFilter\PaymentFilter;

/**
 * Class Payment
 * @package Opg\Core\Model\Entity\Payment
 *
 * @ORM\Entity(repositoryClass="Application\Model\Repository\PaymentRepository")
 * @ORM\Table(name = "payments")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "payment_cheque" = "Opg\Core\Model\Entity\Payment\ChequePayment",
 *     "payment_online" = "Opg\Core\Model\Entity\Payment\OnlinePayment",
 *     "payment_card"   = "Opg\Core\Model\Entity\Payment\CardPayment",
 *     "payment_cash"   = "Opg\Core\Model\Entity\Payment\CashPayment",
 * })
 */
abstract class PaymentType implements EntityInterface, \IteratorAggregate
{
    use ToArray;
    use InputFilter;

    const PAYMENT_TYPE_CASH     = 'Cash';
    const PAYMENT_TYPE_CARD     = 'Card';
    const PAYMENT_TYPE_ONLINE   = 'Online';
    const PAYMENT_TYPE_CHEQUE   = 'Cheque';

    /**
     * @ORM\Column(
     *      type = "integer",
     *      options = {"unsigned": true}
     * )
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Id
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $paymentReference;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getPaymentDateString", setter="setPaymentDateString")
     */
    protected $paymentDate;

    /**
     * @ORM\Column(type="decimal")
     * @Type("float")
     * @var float
     */
    protected $paymentAmount;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $feeNumber;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     * @Type("float")
     * @var float
     */
    protected $feeAmount;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $burnNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $batchNumber;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @ReadOnly
     */
    protected $paymentType;

    /**
     * @var \Opg\Core\Model\Entity\CaseItem\CaseItem
     */
    protected $case;

    /**
     * @return InputFilter|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (null === $this->inputFilter) {
            $this->inputFilter = new \Zend\InputFilter\InputFilter();

            $paymentFilter =  new PaymentFilter();

            foreach ($paymentFilter->getInputs() as $name=>$input) {
                $this->inputFilter->add($input, $name);
            }
        }

        return $this->inputFilter;
    }

    /**
     * @return \RecursiveArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * @param int $id
     * @return PaymentType
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $paymentReference
     * @return PaymentType
     */
    public function setPaymentReference($paymentReference)
    {
        $this->paymentReference = $paymentReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentReference()
    {
        return $this->paymentReference;
    }

    /**
     * @param \DateTime $paymentDate
     * @return PaymentType
     */
    public function setPaymentDate(\DateTime $paymentDate = null)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @param string $paymentDate
     * @return PaymentType
     */
    public function setPaymentDateString($paymentDate)
    {
        if (!empty(trim($paymentDate))) {
            $this->setPaymentDate(DateFormat::createDateTime($paymentDate));
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return string
     */
    public function getPaymentDateString()
    {
        if ($this->paymentDate instanceof \DateTime) {
            return $this->paymentDate->format(DateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param float $amount
     * @return PaymentType
     */
    public function setPaymentAmount($amount)
    {
        $this->paymentAmount = (float)$amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentAmount()
    {
        return number_format($this->paymentAmount, 2, '.', '');
    }

    /**
     * @param string $feeNumber
     * @return PaymentType
     */
    public function setFeeNumber($feeNumber)
    {
        $this->feeNumber = $feeNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeeNumber()
    {
        return $this->feeNumber;
    }

    /**
     * @param float $feeAmount
     * @return PaymentType
     */
    public function setFeeAmount($feeAmount)
    {
        $this->feeAmount = (float)$feeAmount;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeeAmount()
    {
        return number_format($this->feeAmount,2, '.', '');
    }

    /**
     * @param string $burnNumber
     * @return PaymentType
     */
    public function setBurnNumber($burnNumber)
    {
        $this->burnNumber = $burnNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getBurnNumber()
    {
        return $this->burnNumber;
    }

    /**
     * @param string $batchNumber
     * @return PaymentType
     */
    public function setBatchNumber($batchNumber)
    {
        $this->batchNumber = $batchNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getBatchNumber()
    {
        return $this->batchNumber;
    }

    /**
     * @param CaseItem $case
     * @return PaymentType
     * @throws \LogicException
     */
    public function setCase(CaseItem $case)
    {
        if (null !== $this->case && $this->case = $case) {
            throw new \LogicException('This payment has already been assigned to a case');
        }
        $this->case = $case;

        return $this;
    }

    /**
     * @return CaseItem
     */
    public function getCase()
    {
        return $this->case;
    }
}
