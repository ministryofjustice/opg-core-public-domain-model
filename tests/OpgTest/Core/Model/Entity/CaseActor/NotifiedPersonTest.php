<?php
namespace OpgTest\Core\Model\Entity\CaseActor;

use Zend\InputFilter\InputFilter;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;

class NotifiedPersonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NotifiedPerson
     */
    private $notifiedPerson;

    public function setUp()
    {
        $this->notifiedPerson = new NotifiedPerson();
    }

    public function testGetSetNoticeGivenDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->notifiedPerson->getNoticeGivenDate());
        $this->assertEmpty($this->notifiedPerson->getDateAsString('noticeGivenDate'));

        $this->notifiedPerson->setNoticeGivenDate($expectedDate);
        $this->assertEquals($expectedDate, $this->notifiedPerson->getNoticeGivenDate());
    }

    public function testSetGetNotifiedDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->notifiedPerson->getNoticeGivenDate());
        $this->notifiedPerson->setNoticeGivenDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->notifiedPerson->getNoticeGivenDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    //remember date format for this one
    public function testSetGetNotifiedDateEmptyString()
    {
        $this->assertEmpty($this->notifiedPerson->getDateAsString('noticeGivenDate'));
        $this->notifiedPerson->setDateFromString('', 'noticeGivenDate');

        $this->assertEmpty($this->notifiedPerson->getDateTimeAsString('noticeGivenDate'));
    }

    public function testSetGetNotifiedDateInvalidString()
    {
        $this->assertEmpty($this->notifiedPerson->getDateTimeAsString('noticeGivenDate'));
        try {
            $this->notifiedPerson->setDateTimeFromString('asddasdsdas', 'noticeGivenDate');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testSetGetNotifiedDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->notifiedPerson->setDateFromString($expected,'noticeGivenDate');
        $this->assertEquals($expected, $this->notifiedPerson->getDateAsString('noticeGivenDate'));

    }

    public function testGetInputFilter()
    {
        $this->assertTrue($this->notifiedPerson->getInputFilter() instanceof InputFilter);
    }

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Sibling';
        $this->notifiedPerson->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->notifiedPerson->getRelationshipToDonor());
    }
}
