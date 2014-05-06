<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

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
        $this->notifiedPerson->setNotifiedDate($expectedDate);

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

    public function testToArrayExchangeArray()
    {
        $this->notifiedPerson
            ->setId('1')
            ->setEmail('notifiedperson@domain.com')
            ->setCases(new ArrayCollection());


        $notifiedPerson = $this->notifiedPerson->toArray();

        $notifiedPerson2 = $this->notifiedPerson->exchangeArray($notifiedPerson);

        $this->assertArrayHasKey('className',$notifiedPerson);
        $this->assertEquals(get_class($notifiedPerson2), $notifiedPerson['className']);
        $this->assertEquals($this->notifiedPerson, $notifiedPerson2);
        $this->assertEquals($notifiedPerson, $notifiedPerson2->toArray());
    }

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Sibling';
        $this->notifiedPerson->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->notifiedPerson->getRelationshipToDonor());
    }
}
