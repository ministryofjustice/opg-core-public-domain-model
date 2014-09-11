<?php

namespace OpgTest\Core\Model\Entity\CaseActor;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\NotifiedAttorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
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

    public function testGetSetEpaNotifiedAttorneyNoticeGivenDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDate());
        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDateString());

        $this->na->setEpaNotifiedAttorneyNoticeGivenDate($expectedDate);
        $this->assertEquals($expectedDate, $this->na->getEpaNotifiedAttorneyNoticeGivenDate());
    }

    public function testGetSetEpaNotifiedAttorneyNoticeGivenDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDate());
        $this->na->setEpaNotifiedAttorneyNoticeGivenDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->na->getEpaNotifiedAttorneyNoticeGivenDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetEpaNotifiedAttorneyNoticeGivenDateEmptyString()
    {

        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDate());
        $this->na->setEpaNotifiedAttorneyNoticeGivenDateString('');

        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDate());
    }

    public function testGetSetEpaNotifiedAttorneyNoticeGivenDateInvalidString()
    {
        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDateString());
        try {
            $this->na->setEpaNotifiedAttorneyNoticeGivenDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }

        $this->assertEmpty($this->na->getEpaNotifiedAttorneyNoticeGivenDateString());

    }

    public function testGetSetEpaNotifiedAttorneyNoticeGivenDateValidString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->na->setEpaNotifiedAttorneyNoticeGivenDateString($expected);

        $this->assertEquals($expected, $this->na->getEpaNotifiedAttorneyNoticeGivenDateString());
    }
    
}
