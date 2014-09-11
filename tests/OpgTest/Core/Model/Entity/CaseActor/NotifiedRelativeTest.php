<?php

namespace OpgTest\Core\Model\Entity\CaseActor;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\NotifiedRelative;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class NotifiedRelativeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NotifiedRelative
     */
    protected $na;

    public function setUp()
    {
        $this->na = new NotifiedRelative();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->na instanceof NotifiedRelative);
    }

    public function testGetSetEpaNotifiedRelativeNoticeGivenDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDate());
        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDateString());

        $this->na->setEpaNotifiedRelativeNoticeGivenDate($expectedDate);
        $this->assertEquals($expectedDate, $this->na->getEpaNotifiedRelativeNoticeGivenDate());
    }

    public function testGetSetEpaNotifiedRelativeNoticeGivenDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDate());
        $this->na->setEpaNotifiedRelativeNoticeGivenDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->na->getEpaNotifiedRelativeNoticeGivenDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetEpaNotifiedRelativeNoticeGivenDateEmptyString()
    {

        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDate());
        $this->na->setEpaNotifiedRelativeNoticeGivenDateString('');

        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDate());
    }

    public function testGetSetEpaNotifiedRelativeNoticeGivenDateInvalidString()
    {
        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDateString());
        try {
            $this->na->setEpaNotifiedRelativeNoticeGivenDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }

        $this->assertEmpty($this->na->getEpaNotifiedRelativeNoticeGivenDateString());

    }

    public function testGetSetEpaNotifiedRelativeNoticeGivenDateValidString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->na->setEpaNotifiedRelativeNoticeGivenDateString($expected);

        $this->assertEquals($expected, $this->na->getEpaNotifiedRelativeNoticeGivenDateString());
    }
    
}
