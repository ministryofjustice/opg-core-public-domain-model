<?php

namespace OpgTest\Core\Model\Entity\Payment;


use Opg\Core\Model\Entity\Payment\ChequePayment;
use Zend\InputFilter\InputFilter;

class ChequePaymentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ChequePayment
     */
    protected $chequePayment;

    public function setUp()
    {
        $this->chequePayment = new ChequePayment();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->chequePayment instanceof ChequePayment);
    }

}

