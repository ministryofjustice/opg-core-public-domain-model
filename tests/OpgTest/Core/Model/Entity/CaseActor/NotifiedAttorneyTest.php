<?php

namespace OpgTest\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\NotifiedAttorney;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class NotifiedAttorneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NotifiedAttorney
     */
    protected $na;

    public function setUp()
    {
        $this->na = new NotifiedAttorney();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->na instanceof NotifiedAttorney);
    }

    public function testGetsetNoticeGivenDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->na->getNoticeGivenDate());
        $this->assertEmpty($this->na->getNoticeGivenDateString());

        $this->na->setNoticeGivenDate($expectedDate);
        $this->assertEquals($expectedDate, $this->na->getNoticeGivenDate());
    }

    public function testGetsetNoticeGivenDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->na->getNoticeGivenDate());
        $this->na->setNoticeGivenDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->na->getNoticeGivenDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetsetNoticeGivenDateEmptyString()
    {

        $this->assertEmpty($this->na->getNoticeGivenDate());
        $this->na->setNoticeGivenDateString('');

        $this->assertEmpty($this->na->getNoticeGivenDate());
    }

    public function testGetsetNoticeGivenDateInvalidString()
    {
        $this->assertEmpty($this->na->getNoticeGivenDateString());
        try {
            $this->na->setNoticeGivenDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }

        $this->assertEmpty($this->na->getNoticeGivenDateString());

    }

    public function testGetsetNoticeGivenDateValidString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->na->setNoticeGivenDateString($expected);

        $this->assertEquals($expected, $this->na->getNoticeGivenDateString());
    }

}
