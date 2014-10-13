<?php

namespace Opg\Core\Model\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ReadOnly;

/**
 * @ORM\Entity
 *
 * Class Cheque
 * @package Opg\Core\Model\Entity\Payment
 */
class CashPayment extends PaymentType
{
    /**
     * @ORM\Column(type="string")
     * @var string
     * @ReadOnly
     */
    protected $paymentType = self::PAYMENT_TYPE_CASH;
}
