<?php

namespace OpgTest\Core\Model\Entity\Payment;


use Opg\Core\Model\Entity\Payment\CashPayment;

class CashPaymentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CashPayment
     */
    protected $payment;

    public function setUp()
    {
        $this->payment = new CashPayment();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->payment instanceof CashPayment);
    }

}

