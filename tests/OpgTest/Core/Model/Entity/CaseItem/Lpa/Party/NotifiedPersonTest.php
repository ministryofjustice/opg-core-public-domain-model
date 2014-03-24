<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Common\Exception\UnusedException;

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

    public function testSetGetNotifiedPerson()
    {
        $expected = '1993-11-22';

        $this->notifiedPerson->setNotifiedDate($expected);

        $this->assertEquals(
            $expected,
            $this->notifiedPerson->getNotifiedDate()
        );
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

    public function testIsValid()
    {
        $this->assertFalse($this->notifiedPerson->isValid());

        $errors = $this->notifiedPerson->getErrorMessages();
        $this->assertArrayHasKey('surname',$errors['errors']);
        $this->assertArrayHasKey('powerOfAttorneys',$errors['errors']);

        $this->notifiedPerson->addCase(new Lpa());
        $this->notifiedPerson->setSurname('Test-Surname');
        $this->assertTrue($this->notifiedPerson->isValid());
    }

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Sibling';
        $this->notifiedPerson->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->notifiedPerson->getRelationshipToDonor());
    }
}
