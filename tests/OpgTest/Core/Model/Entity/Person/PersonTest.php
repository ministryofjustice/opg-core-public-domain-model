<?php

namespace OpgTest\Core\Model\Entity\Person;

use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\Deputyship\DeputyshipCollection;
use Opg\Core\Model\Entity\Deputyship\Deputyship;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\Person\Person;
use \Exception;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;

/**
 * Person test case.
 */
class PersonTest extends \PHPUnit_Framework_TestCase
{

    private $person;

    protected function setUp ()
    {
        $this->person = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Person\Person');
    }

    public function testCreate()
    {
        $this->assertTrue($this->person instanceof Person);
    }

    public function testSetGetEmail ()
    {
        $expected = 'email@tld.com';

        $this->person->setEmail($expected);
        $this->assertEquals($expected, $this->person->getEmail());
    }

    public function testSetGetId ()
    {
        $expected = '123-AAABBB-CCC-123';

        $this->person->setId($expected);
        $this->assertEquals($expected, $this->person->getId());
    }

    public function testSetGetDob ()
    {
        $expected = new \DateTime();
        $expectedString = $expected->format('d-m-Y H:i:s');

        $this->person->setDob($expectedString);
        $returnDOB = $this->person->getDob();

        $this->assertEquals($expectedString, $returnDOB);
    }

    public function testSetGetTitle ()
    {
        $expected  = 'Mr';

        $this->person->setTitle($expected);
        $this->assertEquals($this->person->getTitle(), $expected);
    }

    public function testSetGetSalutation ()
    {
        $expected  = 'Mr';

        $this->person->setSalutation($expected);
        $this->assertEquals($expected, $this->person->getSalutation());
    }

    public function testSetGetNames ()
    {
        $expectedFirst = 'First';
        $expectedMiddle = 'Middle';
        $expectedSurname = 'Surname';

        $this->person->setFirstname($expectedFirst)->setMiddlename($expectedMiddle)->setSurname($expectedSurname);

        $this->assertNotEquals($this->person->getSurname(), $expectedFirst);
        $this->assertEquals($expectedFirst, $this->person->getFirstname());
        $this->assertEquals($expectedMiddle, $this->person->getMiddlename());
        $this->assertEquals($expectedSurname, $this->person->getSurname());
    }

    public function testAddCase ()
    {
        $case = new Lpa();
        $this->person->addCase($case);

        $collection = $this->person->getPowerOfAttorneys();

        $collection = $collection->toArray();
        $this->assertEquals(count($collection), 1);

        $case = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Deputyship\Deputyship');
        $this->person->addCase($case);
        $collection2 = $this->person->getDeputyships();

    }

    public function testAddCaseCollection ()
    {

        $collection = $this->person->getPowerOfAttorneys();
        $collection2 = $this->person->getDeputyships();

        for($i=0;$i<5; $i++) {
            $case = new Lpa();
            $collection->add($case);
        }

        $this->person->setCases($collection);

        $collection3 = $this->person->getPowerOfAttorneys();

        $this->assertEquals($collection, $collection3);

        for($i=0;$i<5; $i++) {
            $case = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Deputyship\Deputyship');
            $collection2->add($case);
        }

        $this->person->setCases($collection2);

        $collection4 = $this->person->getDeputyships();

        $this->assertEquals($collection4, $collection2);

        $this->assertEquals(array($collection, $collection2), $this->person->getCases());

        $cases = $this->person->getCases();
        $this->assertTrue(count($cases) == 2);
        $this->assertEquals($collection3, $cases[0]);
    }

    public function testFailOnInvalidCaseType()
    {
        $invalidCase = $this->getMockForAbstractClass('Opg\Core\Model\Entity\CaseItem\CaseItem');
        $expectedMessage = 'A case can only be of type PowerOfAttorney or DeputyShip';

        try {
            $this->person->addCase($invalidCase);
        }
        catch(Exception $e) {
            $this->assertTrue($e instanceof Exception);
            $this->assertEquals($expectedMessage, $e->getMessage());
        }
    }


    public function testGetSetUniqueIdentifier()
    {
        $expectedUID = '7123456789012';

        $this->person->setUid($expectedUID);

        $this->assertEquals($expectedUID, $this->person->getUid());
    }

    public function testAddressFunctions()
    {
        $this->person->clearAddresses();
        $this->assertEmpty($this->person->getAddresses()->toArray());

        $homeAddress = new Address();
        $homeAddress
            ->setId(1)
            ->setAddressLines(array('My Address', 'My Street'))
            ->setTown('My Town')
            ->setPostcode('My Postcode')
            ->setType('home');

        $workAddress = new Address();
        $workAddress
            ->setId(2)
            ->setAddressLines(array('My Work Address', 'My Street'))
            ->setTown('My Town')
            ->setPostcode('My Postcode')
            ->setType('work');

        $this->person->addAddress($homeAddress);
        $this->person->addAddress($workAddress);

        $addressCollection = $this->person->getAddresses();
        $this->assertTrue($addressCollection->contains($homeAddress));
        $this->assertTrue($addressCollection->contains($workAddress));

        $this->person->setAddresses($addressCollection);
        $this->assertEquals($addressCollection, $this->person->getAddresses());
    }

    public function testPhoneNumberFunctions()
    {
        $this->person->clearPhoneNumbers();
        $this->assertEmpty($this->person->getPhoneNumbers()->toArray());

        $homePhone = new PhoneNumber();
        $homePhone
            ->setType('home')
            ->setPhoneNumber('12345678900');

        $workPhone = new PhoneNumber();
        $workPhone
            ->setType('work')
            ->setPhoneNumber('12345678912');

        $this->person->addPhoneNumber($homePhone);
        $this->person->addPhoneNumber($workPhone);

        $phoneCollection = $this->person->getPhoneNumbers();
        $this->assertTrue($phoneCollection->contains($homePhone));
        $this->assertTrue($phoneCollection->contains($workPhone));

        $this->person->setPhoneNumbers($phoneCollection);
        $this->assertEquals($phoneCollection, $this->person->getPhoneNumbers());
    }

    public function testGetSetInputFilter()
    {
        $inputFilter = $this->person->getInputFilter();
        $this->person->setInputFilter($inputFilter);
        $this->assertEquals($inputFilter, $this->person->getInputFilter());
    }

    public function testGetSetDateOfDeath()
    {
        $this->assertNull($this->person->getDateOfDeath());
        $this->assertFalse($this->person->isDeceased());

        $expectedDate = date('d/m/Y');
        $this->person->setDateOfDeath($expectedDate);
        $this->assertNotNull($this->person->getDateOfDeath());
        $this->assertEquals($expectedDate, $this->person->getDateOfDeath());
        $this->assertTrue($this->person->isDeceased());
    }

  }

