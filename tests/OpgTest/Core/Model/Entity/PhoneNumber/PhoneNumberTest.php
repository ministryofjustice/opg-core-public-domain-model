<?php

namespace OpgTest\Core\Model\Entity\PhoneNumber;

use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;
use Zend\InputFilter\InputFilter;

class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PhoneNumber
     */
    protected $phoneNumber;

    public function setUp()
    {
        $this->phoneNumber = new PhoneNumber();
    }

    public function testGetSetId()
    {
        $id = 100;
        $this->phoneNumber->setId($id);

        $this->assertEquals($id, $this->phoneNumber->getId());
    }

    public function testGetSetPerson()
    {
        $donor = new Donor();
        $donor->setId(1);
        $donor->setFirstname('Test');

        $this->phoneNumber->setPerson($donor);
        $this->assertEquals($donor, $this->phoneNumber->getPerson());
    }

    public function testOverwritePersonSameIdThrowsNoException()
    {
        $donor = new Donor();
        $donor->setId(1);
        $donor->setFirstName('Test');


        $this->phoneNumber->setPerson($donor);
        $this->assertEquals($donor, $this->phoneNumber->getPerson());

        $this->phoneNumber->setPerson($donor);
    }

    /**
     * @expectedException \LogicException
     */
    public function testOverwritePersonDifferentIdThrowsException()
    {
        $donor = new Donor();
        $donor->setId(1);
        $donor->setFirstName('Test');


        $this->phoneNumber->setPerson($donor);
        $this->assertEquals($donor, $this->phoneNumber->getPerson());

        $secondDonor = new Donor();
        $secondDonor->setId(2);
        $this->phoneNumber->setPerson($secondDonor);
    }

    public function testGetSetPhoneNumber()
    {
        $this->phoneNumber->setPhoneNumber('020 811 8181');
        $this->assertEquals('0208118181', $this->phoneNumber->getPhoneNumber());
    }

    public function testGetSetType()
    {
        $type = 'Test';
        $this->phoneNumber->setType($type);
        $this->assertEquals($type, $this->phoneNumber->getType());
    }

    public function testGetSetDefault()
    {
        $this->assertFalse($this->phoneNumber->getDefault());
        $this->phoneNumber->setDefault(true);
        $this->assertTrue($this->phoneNumber->getDefault());
    }

    public function testGetInputFilter()
    {
        $this->assertTrue(
            $this->phoneNumber->getInputFilter() instanceof InputFilter
        );
    }
}
