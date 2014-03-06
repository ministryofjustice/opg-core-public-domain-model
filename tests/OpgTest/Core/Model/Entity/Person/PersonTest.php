<?php

namespace OpgTest\Core\Model\Entity\Person;

use Opg\Core\Model\Entity\Deputyship\DeputyshipCollection;
use Opg\Core\Model\Entity\Deputyship\Deputyship;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\Person\Person;
use \Exception;

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
  }

