<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
/**
 * ToArray test case.
 */
class DonorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Donor
     */
    private $donor;

    public function setUp()
    {
        $this->donor = new Donor();
    }

    public function testSetGetPreviousNames()
    {
        $expected = 'Martha Jones, Jimmy Jones';

        $this->donor->setPreviousNames($expected);
        $this->assertEquals(
            $expected,
            $this->donor->getPreviousNames()
        );
    }

    public function testExchangeArray()
    {
        $data = array('cannotSignForm'=>NULL);

        $response = $this->donor->exchangeArray($data);

        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor', $response);
    }

    public function testGetInputFilter()
    {
        $response = $this->donor->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $response);
    }

    public function testSetGetCannotSignForm()
    {
        $this->donor->setCannotSignForm(true);
        $this->assertTrue($this->donor->cannotSignForm());

        $this->donor->setCannotSignForm(false);
        $this->assertFalse($this->donor->cannotSignForm());
    }

    public function testSetGetApplyFeeRemission()
    {
        $this->donor->setApplyingForFeeRemission(true);
        $this->assertTrue($this->donor->isApplyingForFeeRemission());

        $this->donor->setApplyingForFeeRemission(false);
        $this->assertFalse($this->donor->isApplyingForFeeRemission());
    }

    public function testSetGetIsReceivingBenefits()
    {
        $this->donor->setReceivingBenefits(true);
        $this->assertTrue($this->donor->isReceivingBenefits());

        $this->donor->setReceivingBenefits(false);
        $this->assertFalse($this->donor->isReceivingBenefits());
    }

    public function testSetGetReceivedDamageAward()
    {
        $this->donor->setReceivedDamageAward(true);
        $this->assertTrue($this->donor->hasReceivedDamageAward());

        $this->donor->setReceivedDamageAward(false);
        $this->assertFalse($this->donor->hasReceivedDamageAward());
    }

    public function testSetGetHasLowIncome()
    {
        $this->donor->setHasLowIncome(true);
        $this->assertTrue($this->donor->hasLowIncome());

        $this->donor->setHasLowIncome(false);
        $this->assertFalse($this->donor->hasLowIncome());
    }

    public function testSetGetHasPreviousLpa()
    {
        $this->donor->setHasPreviousLpa(true);
        $this->assertTrue($this->donor->hasPreviousLpa());

        $this->donor->setHasPreviousLpa(false);
        $this->assertFalse($this->donor->hasPreviousLpa());
    }

    public function testSetGetSignatureDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->donor->getSignatureDate());
        $this->assertEmpty($this->donor->getSignatureDateString());
        $this->donor->setSignatureDate($expectedDate);

        $this->assertEquals(
            $expectedDate,
            $this->donor->getSignatureDate()
        );
    }

    public function testSetGetSignatureDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->donor->getSignatureDate());
        $this->donor->setSignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->donor->getSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testSetGetSignatureDateEmptyString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->donor->getSignatureDateString());
        $this->donor->setSignatureDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->donor->getSignatureDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testSetGetNotesForPreviousLpa()
    {
        $expected = '2014-20-01';

        $this->donor->setNotesForPreviousLpa($expected);
        $this->assertEquals(
            $expected,
            $this->donor->getNotesForPreviousLpa()
        );
    }

    public function testGetIterator()
    {
        $iterator = $this->donor->getIterator();

        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
}
