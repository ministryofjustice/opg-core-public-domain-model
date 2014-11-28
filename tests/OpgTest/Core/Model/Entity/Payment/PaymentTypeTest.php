<?php

namespace OpgTest\Core\Model\Entity\Payment;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Common\Model\Entity\Exception\InvalidDateFormatException;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa;
use Opg\Core\Model\Entity\Payment\PaymentType;
use Zend\I18n\Validator\DateTime;

/**
 * Class PaymentTypeTest
 * @package OpgTest\Core\Model\Entity\Payment
 */
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
        $this->assertTrue($this->paymentType->getIterator() instanceof \Traversable);
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

    public function testGetSetPaymentAmount()
    {
        $expected = 2;
        $expectedResult = number_format($expected, 2, '.', '');

        $this->paymentType->setPaymentAmount($expected);
        $this->assertEquals($expectedResult, $this->paymentType->getPaymentAmount());
        $this->assertEquals($expected, $this->paymentType->getPaymentAmount());
    }

    public function testValidators()
    {
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(2, $this->paymentType->getErrorMessages()['errors']);

        $this->assertEquals(
            "Value is required and can't be empty",
            $this->paymentType->getErrorMessages()['errors']['paymentAmount']['isEmpty']
        );
        $this->assertEquals(
            "Value is required and can't be empty",
            $this->paymentType->getErrorMessages()['errors']['paymentReference']['isEmpty']
        );

        $this->paymentType->setPaymentReference('a');
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(2, $this->paymentType->getErrorMessages()['errors']);
        $this->assertNotEmpty($this->paymentType->getErrorMessages()['errors']['paymentReference']['stringLengthTooShort']);

        $this->paymentType->setPaymentReference('aa');
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(1, $this->paymentType->getErrorMessages()['errors']);

        $this->paymentType->setPaymentAmount('-1.00');
        $this->assertFalse($this->paymentType->isValid());
        $this->assertCount(1, $this->paymentType->getErrorMessages()['errors']);
        $this->assertNotEmpty($this->paymentType->getErrorMessages()['errors']['paymentAmount']['notDigits']);

        $this->paymentType->setPaymentAmount('1.00');
        $this->assertTrue($this->paymentType->isValid());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetSetCase()
    {
        $case  = (new Lpa())->setId(1);
        $case2 = (new Lpa())->setId(2);

        $this->paymentType->setCase($case);
        $this->assertEquals($case, $this->paymentType->getCase());

        $this->assertEquals($case, $this->paymentType->setCase($case)->getCase());
        $this->assertEquals($case, $this->paymentType->setCase($case2)->getCase());
    }

    public function testGetSetPaymentReference()
    {
        $expected = 'Payment Ref';

        $this->assertEmpty($this->paymentType->getPaymentReference());
        $this->assertEquals(
            $expected,
            $this->paymentType->setPaymentReference($expected)->getPaymentReference()
        );
    }

    /**
     * @expectedException \Opg\Common\Model\Entity\Exception\InvalidDateFormatException
     */
    public function testGetSetPaymentDate()
    {
        $expectedDateTime = new \DateTime();
        $expectedDateTimeString = $expectedDateTime->format(DateFormat::getDateFormat());

        $this->assertNull($this->paymentType->getPaymentDate());
        $this->assertEmpty($this->paymentType->getDateAsString('paymentDate'));

        $this->assertEquals(
            $expectedDateTime,
            $this->paymentType->setPaymentDate($expectedDateTime)->getPaymentDate()
        );

        $this->assertEquals(
            $expectedDateTimeString,
            $this->paymentType->setDateFromString($expectedDateTimeString,'paymentDate')->getDateAsString('paymentDate')
        );

        $this->paymentType->setDateFromString('Last thursday around 3pm', 'paymentDate');
    }

    public function testGetSetFeeAmount()
    {
        $expected = 2;
        $expectedResult = number_format($expected, 2, '.', '');

        $this->paymentType->setFeeAmount($expected);
        $this->assertEquals($expectedResult, $this->paymentType->getFeeAmount());
        $this->assertEquals($expected, $this->paymentType->getFeeAmount());
    }

    public function testGetSetBurnNumber()
    {
        $expected = uniqid('BURN');

        $this->assertEmpty($this->paymentType->getBurnNumber());
        $this->assertEquals(
            $expected,
            $this->paymentType->setBurnNumber($expected)->getBurnNumber()
        );
    }

    public function testGetSetBatchNumber()
    {
        $expected = '01234ABC';

        $this->assertEmpty($this->paymentType->getBatchNumber());
        $this->assertEquals(
            $expected,
            $this->paymentType->setBatchNumber($expected)->getBatchNumber()
        );
    }

}
