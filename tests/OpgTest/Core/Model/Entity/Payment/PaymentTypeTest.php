<?php

namespace OpgTest\Core\Model\Entity\Payment;


use Opg\Core\Model\Entity\Payment\PaymentType;

class PaymentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentType
     */
    protected $paymentType;

    public function setUp()
    {
        $this->paymentType = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Payment\PaymentType');
    }

    public function testSetUp()
    {
        $this->assertTrue($this->paymentType instanceof PaymentType);
    }

    public function testSetGetId()
    {
        $expected = 50;

        $this->paymentType->setId($expected);
        $this->assertTrue(is_int($this->paymentType->getId()));
        $this->assertEquals(
            $expected,
            $this->paymentType->getId()
        );
    }

    public function testGetSetFeeNumber()
    {
        $expected = 'payment reference';
        $this->paymentType->setFeeNumber($expected);

        $this->assertTrue(is_string($this->paymentType->getFeeNumber()));
        $this->assertEquals($expected, $this->paymentType->getFeeNumber());
    }

    public function testGetSetAmount()
    {
        $expected = 2;
        $expectedResult = number_format($expected, 2, '.', '');

        $this->paymentType->setAmount($expected);
        $this->assertEquals($expectedResult, $this->paymentType->getAmount());
        $this->assertEquals($expected, $this->paymentType->getAmount());
    }
}
