<?php


namespace Opg\Core\Model\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Validation\InputFilter\PaymentFilter;
use Zend\InputFilter\Factory as InputFactory;

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
 *     "payment_cheque" = "Opg\Core\Model\Entity\Payment\Cheque",
 * })
 */
abstract class PaymentType implements EntityInterface, \IteratorAggregate
{
    use ToArray;
    use InputFilter;

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
    protected $feeNumber;

    /**
     * @ORM\Column(type="decimal")
     * @var float
     */
    protected $amount;

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
     * @param float $amount
     * @return PaymentType
     */
    public function setAmount($amount)
    {
        $this->amount = (float)$amount;

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return number_format($this->amount, 2, '.', '');
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
}
