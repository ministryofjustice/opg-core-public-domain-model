<?php

namespace OpgTest\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\CaseActor\ReplacementAttorney;

class ReplacementAttorneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReplacementAttorney
     */
    protected $attorney;

    public function setUp()
    {
        $this->attorney = new ReplacementAttorney();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->attorney instanceof ReplacementAttorney);
        $this->assertFalse($this->attorney->isActive());
    }

    public function testSetGetIsReplacementAttorney()
    {
        $this->attorney->setIsReplacementAttorney(true);
        $this->assertTrue($this->attorney->isReplacementAttorney());

        $this->attorney->setIsReplacementAttorney(false);
        $this->assertFalse($this->attorney->isReplacementAttorney());
    }

    public function testGetSetLpaPartCSignatureDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());
        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());

        $this->attorney->setLpaPartCSignatureDate($expectedDate);
        $this->assertEquals($expectedDate, $this->attorney->getLpaPartCSignatureDate());
    }

    public function testGetSetLpaPartCSignatureDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());
        $this->attorney->setDefaultDateFromString('', 'lpaPartCSignatureDate');

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->attorney->getLpaPartCSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testSetGetNotifiedDateEmptyString()
    {
        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());
        $this->attorney->setLpaPartCSignatureDateString('');

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());
    }

    public function testSetGetNotifiedDateInvalidString()
    {
        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());
        try {
            $this->attorney->setLpaPartCSignatureDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testSetGetNotifiedDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->attorney->setLpaPartCSignatureDateString($expected);
        $this->assertEquals($expected, $this->attorney->getLpaPartCSignatureDateString());

    }

}
