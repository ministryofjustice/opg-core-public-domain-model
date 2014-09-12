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

    public function testSetGetNotifiedDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->notifiedPerson->getNotifiedDate());
        $this->assertEmpty($this->notifiedPerson->getNotifiedDateString());

        $this->notifiedPerson->setNotifiedDate($expectedDate);
        $this->assertEquals($expectedDate, $this->notifiedPerson->getNotifiedDate());
    }

    public function testSetGetNotifiedDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->notifiedPerson->getNotifiedDate());
        $this->notifiedPerson->setNotifiedDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->notifiedPerson->getNotifiedDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    //remember date format for this one
    public function testSetGetNotifiedDateEmptyString()
    {
        $this->assertEmpty($this->notifiedPerson->getNotifiedDateString());
        $this->notifiedPerson->setNotifiedDateString('');

        $this->assertEmpty($this->notifiedPerson->getNotifiedDateString());
    }

    public function testSetGetNotifiedDateInvalidString()
    {
        $this->assertEmpty($this->notifiedPerson->getNotifiedDateString());
        try {
            $this->notifiedPerson->setNotifiedDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testSetGetNotifiedDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->notifiedPerson->setNotifiedDateString($expected);
        $this->assertEquals($expected, $this->notifiedPerson->getNotifiedDateString());

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
