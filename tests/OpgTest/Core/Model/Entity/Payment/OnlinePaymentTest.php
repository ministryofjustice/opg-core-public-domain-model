<?php

namespace OpgTest\Core\Model\Entity\Payment;


use Opg\Core\Model\Entity\Payment\OnlinePayment;

class OnlinePaymentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OnlinePayment
     */
    protected $payment;

    public function setUp()
    {
        $this->payment = new OnlinePayment();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->payment instanceof OnlinePayment);
    }

}

