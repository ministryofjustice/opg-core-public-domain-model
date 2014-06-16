<?php
/**
 * Created by PhpStorm.
 * User: brettm
 * Date: 24/02/14
 * Time: 20:37
 */

namespace OpgTest\Core\Model\Entity\PhoneNumber;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;

class PhoneNumberTest extends \PHPUnit_Framework_TestCase
{

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

    public function testOverwritePersonThrowsException()
    {
        $donor = new Donor();
        $donor->setId(1);
        $donor->setFirstName('Test');


        $this->phoneNumber->setPerson($donor);
        $this->assertEquals($donor, $this->phoneNumber->getPerson());

        try {
            $this->phoneNumber->setPerson($donor);
        }
        catch(\Exception $e) {
            $this->assertInstanceOf('\LogicException', $e);
        }
    }

    public function testGetSetPhoneNumber()
    {
        $phoneNumber = 123456789;
        $this->phoneNumber->setPhoneNumber($phoneNumber);
        $this->assertEquals($phoneNumber, $this->phoneNumber->getPhoneNumber());
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
}
