<?php

namespace OpgTest\Core\Model\Entity\Payment;


use Opg\Core\Model\Entity\Payment\CardPayment;

class CardPaymentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CardPayment
     */
    protected $payment;

    public function setUp()
    {
        $this->payment = new CardPayment();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->payment instanceof CardPayment);
    }

}

