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

    public function testSetGetId()
    {
        $expected = 50;

        $this->chequePayment->setId($expected);
        $this->assertTrue(is_int($this->chequePayment->getId()));
        $this->assertEquals(
            $expected,
            $this->chequePayment->getId()
        );
    }

    public function testGetSetFeeNumber()
    {
        $expected = 'payment reference';
        $this->chequePayment->setFeeNumber($expected);

        $this->assertTrue(is_string($this->chequePayment->getFeeNumber()));
        $this->assertEquals($expected, $this->chequePayment->getFeeNumber());
    }

    public function testGetSetAmount()
    {
        $expected = 2;
        $expectedResult = number_format($expected, 2, '.', '');

        $this->chequePayment->setAmount($expected);
        $this->assertEquals($expectedResult, $this->chequePayment->getAmount());
        $this->assertEquals($expected, $this->chequePayment->getAmount());
    }

    public function testGetSetSortCode()
    {
        $expected ='00-00-00';
        $this->assertEmpty($this->chequePayment->getSortCode());
        $this->assertEquals($expected, $this->chequePayment->setSortCode($expected)->getSortCode());
    }

    public function testGetSetAccountNumber()
    {
        $expected ='1234567890';
        $this->assertEmpty($this->chequePayment->getAccountNumber());
        $this->assertEquals($expected, $this->chequePayment->setAccountNumber($expected)->getAccountNumber());
    }

    public function testValidators()
    {
        $this->assertFalse($this->chequePayment->isValid());
        $this->assertCount(2, $this->chequePayment->getErrorMessages()['errors']);

        $this->assertEquals(
            "Value is required and can't be empty",
            $this->chequePayment->getErrorMessages()['errors']['amount']['isEmpty']
        );
        $this->assertEquals(
            "Value is required and can't be empty",
            $this->chequePayment->getErrorMessages()['errors']['feeNumber']['isEmpty']
        );

        $this->chequePayment->setFeeNumber('a');
        $this->assertFalse($this->chequePayment->isValid());
        $this->assertCount(2, $this->chequePayment->getErrorMessages()['errors']);
        $this->assertNotEmpty($this->chequePayment->getErrorMessages()['errors']['feeNumber']['stringLengthTooShort']);

        $this->chequePayment->setFeeNumber('aa');
        $this->assertFalse($this->chequePayment->isValid());
        $this->assertCount(1, $this->chequePayment->getErrorMessages()['errors']);

        $this->chequePayment->setAmount(-1);
        $this->assertFalse($this->chequePayment->isValid());
        $this->assertCount(1, $this->chequePayment->getErrorMessages()['errors']);
        $this->assertNotEmpty($this->chequePayment->getErrorMessages()['errors']['amount']['notDigits']);
        $this->assertNotEmpty($this->chequePayment->getErrorMessages()['errors']['amount']['notGreaterThan']);

        $this->chequePayment->setAmount('1.00');
        $this->assertTrue($this->chequePayment->isValid());
    }
}
