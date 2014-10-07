<?php

namespace OpgTest\Core\Model\Entity\Payment;

use Opg\Core\Model\Entity\Payment\PaymentType;

/**
 * Class PaymentTypeTest
 * @package OpgTest\Core\Model\Entity\Payment
 */
class PayStub extends PaymentType{}

class PaymentTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentType
     */
    protected $paymentType;

    public function setUp()
    {
        $this->paymentType = new PayStub; //$this->getMockForAbstractClass('Opg\Core\Model\Entity\Payment\PaymentType');
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

    public function testValidators()
    {
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(2, $this->paymentType->getErrorMessages()['errors']);

        $this->assertEquals(
            "Value is required and can't be empty",
            $this->paymentType->getErrorMessages()['errors']['amount']['isEmpty']
        );
        $this->assertEquals(
            "Value is required and can't be empty",
            $this->paymentType->getErrorMessages()['errors']['feeNumber']['isEmpty']
        );

        $this->paymentType->setFeeNumber('a');
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(2, $this->paymentType->getErrorMessages()['errors']);
        $this->assertNotEmpty($this->paymentType->getErrorMessages()['errors']['feeNumber']['stringLengthTooShort']);

        $this->paymentType->setFeeNumber('aa');
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(1, $this->paymentType->getErrorMessages()['errors']);

        $this->paymentType->setAmount('-1.00');
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(1, $this->paymentType->getErrorMessages()['errors']);
        $this->assertNotEmpty($this->paymentType->getErrorMessages()['errors']['amount']['notDigits']);

        $this->paymentType->setAmount('1.00');
        $this->assertTrue($this->paymentType->isValid());
    }
}
