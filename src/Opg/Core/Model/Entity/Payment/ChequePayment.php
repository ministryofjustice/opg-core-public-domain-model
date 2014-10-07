<?php

namespace Opg\Core\Model\Entity\Payment;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 *
 * Class Cheque
 * @package Opg\Core\Model\Entity\Payment
 */
class ChequePayment extends PaymentType
{

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $sortCode;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $accountNumber;

    /**
     * @param string $accountNumber
     *
     * @return ChequePayment
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string $sortCode
     *
     * @return ChequePayment
     */
    public function setSortCode($sortCode)
    {
        $this->sortCode = $sortCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getSortCode()
    {
        return $this->sortCode;
    }


}
