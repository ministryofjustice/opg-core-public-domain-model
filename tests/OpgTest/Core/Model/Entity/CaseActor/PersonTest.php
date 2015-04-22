<?php

namespace OpgTest\Core\Model\Entity\Person;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa;
use Opg\Core\Model\Entity\CaseActor\Person;
use \Exception;
use Opg\Core\Model\Entity\Document\IncomingDocument;
use Opg\Core\Model\Entity\Document\OutgoingDocument;
use Opg\Core\Model\Entity\Note\Note;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\Task\Task;
use Opg\Core\Model\Entity\Warning\Warning;

/**
 * Person test case.
 */

class PersonStub extends Person
{
    public function __unset($key) {
        switch($key) {
            case 'warnings' :
                $this->warnings = null;
                break;
        }
    }
}
class PersonTest extends \PHPUnit_Framework_TestCase
{

    /** @var  PersonStub */
    private $person;

    protected function setUp ()
    {
        $this->person = new PersonStub();
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
        $expected = 123456;

        $this->person->setId($expected);
        $this->assertEquals($expected, $this->person->getId());
    }

    public function testSetGetDob()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->person->getDob());
        $this->assertEmpty($this->person->getDobString());

        $this->person->setDob($expectedDate);
        $this->assertEquals($expectedDate, $this->person->getDob());
    }

    public function testSetGetDobNulls()
    {
        $this->assertEmpty($this->person->getDob());
        $this->person->setDob();

        $this->assertEmpty($this->person->getDob());
    }

    public function testGetSetDobEmptyString()
    {
        $this->person->setDobString('');
        $this->assertEmpty($this->person->getDobString());
    }

    public function testSetGetDobInvalidString()
    {
        try {
            $this->person->setDobString('asdfadsfsa');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asdfadsfsa' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
        $this->assertEmpty($this->person->getDobString());
    }

    public function testGetSetDobString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->person->setDobString($expected);
        $this->assertEquals($expected, $this->person->getDobString());
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
        $expectedTitle = 'Mr';
        $expectedFirst = 'First';
        $expectedMiddle = 'Middle';
        $expectedSurname = 'Surname';
        $expectedOtherNames = "Other Known Names";

        $displayParts = array(
            $expectedTitle,
            $expectedFirst,
            $expectedSurname
        );
        $expectedDisplay = implode(' ', $displayParts);

        $this->person
            ->setTitle($expectedTitle)
            ->setFirstname($expectedFirst)
            ->setMiddlename($expectedMiddle)
            ->setSurname($expectedSurname)
            ->setOtherNames($expectedOtherNames);

        $this->assertNotEquals($this->person->getSurname(), $expectedFirst);
        $this->assertEquals($expectedTitle, $this->person->getTitle());
        $this->assertEquals($expectedFirst, $this->person->getFirstname());
        $this->assertEquals($expectedMiddle, $this->person->getMiddlename());
        $this->assertEquals($expectedSurname, $this->person->getSurname());
        $this->assertEquals($expectedOtherNames, $this->person->getOtherNames());
        $this->assertEquals($expectedDisplay, $this->person->getDisplayName());
    }

    public function testAddCase ()
    {
        $case = new Lpa();
        $this->person->addCase($case);

        $collection = $this->person->getCases();

        $collection = $collection->toArray();
        $this->assertEquals(count($collection), 1);

        $case = $this->getMockForAbstractClass('Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship');
        $this->person->addCase($case);
        $collection = $this->person->getCases();

        $collection = $collection->toArray();
        $this->assertEquals(count($collection), 2);

    }

    public function testAddCaseCollection ()
    {
        $collection = new ArrayCollection();
        $collection2 = new ArrayCollection();

        for($i=0;$i<5; $i++) {
            $case = new Lpa();
            $collection->add($case);
        }

        $this->person->setCases($collection);

        $collection3 = $this->person->getPowerOfAttorneys();

        $this->assertEquals($collection, $collection3);

        for($i=0;$i<5; $i++) {
            $case = $this->getMockForAbstractClass('Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship');
            $collection2->add($case);
        }
        $this->person->addCases($collection2);


        $cases = $this->person->getCases()->toArray();
        $deps  = $this->person->getDeputyShips()->toArray();
        $poas  = $this->person->getPowerOfAttorneys()->toArray();
        $caseComp = array_merge($poas, $deps);

        $this->assertEquals($cases, $caseComp);

        $this->assertCount(10, $cases);
        $this->assertCount(10, $caseComp);
    }

    public function testRemoveCase()
    {
        $case1 = (new Lpa())->setId(1);
        $case2 = (new Lpa())->setId(2);

        $this->person->addCase($case1)->addCase($case2);

        $this->assertCount(2, $this->person->getCases()->toArray());

        $this->person->removeCase($case2);

        $this->assertCount(1, $this->person->getCases()->toArray());

        $this->assertTrue($this->person->getCases()->contains($case1));
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

        $expectedDate = new \DateTime();
        $this->person->setDateOfDeath($expectedDate);
        $this->assertNotNull($this->person->getDateOfDeath());
        $this->assertEquals($expectedDate, $this->person->getDateOfDeath());
        $this->assertTrue($this->person->isDeceased());
    }

    public function testDateOfDeathNulls()
    {
        $this->assertEmpty($this->person->getDateOfDeath());
        $this->person->setDateOfDeath();

        $this->assertEmpty($this->person->getDateOfDeath());
    }

    public function testDateOfDeathInvalidString()
    {
        try {
            $this->person->setDateOfDeathString('invalid_date');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'invalid_date' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
        $this->assertEmpty($this->person->getDateOfDeathString());
    }

    public function testDateOfDeathEmptyString()
    {
        $this->person->setDateOfDeathString('');
        $this->assertEmpty($this->person->getDateOfDeathString());
    }

    public function testGetSetDateOfDeathValidString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->person->setDateOfDeathString($expected);
        $this->assertEquals($expected, $this->person->getDateOfDeathString());
    }

    public function testAddPersonCannotBeAParentOfItself()
    {
        $this->setExpectedException('LogicException', 'Person cannot be a parent of itself.');
        $this->person->addChild($this->person);
    }

    public function testAddPerson()
    {
        $otherPerson1 = new PersonStub();
        $otherPerson2 = new PersonStub();

        $this->assertNull($otherPerson1->getParent());
        $this->person->addChild($otherPerson1);
        $this->assertSame($this->person, $otherPerson1->getParent());

        $this->assertNull($otherPerson2->getParent());
        $this->person->addChild($otherPerson2);
        $this->assertSame($this->person, $otherPerson2->getParent());

        $this->assertCount(2, $this->person->getChildren()->toArray());

        $otherPerson1->removeParent();
        $this->person->removeChild($otherPerson1);

        $this->assertCount(1, $this->person->getChildren()->toArray());
    }

    public function testPersonCannotHaveMultipleParents()
    {
        $parent1 = new PersonStub();
        $parent2 = new PersonStub();

        $parent1->addChild($this->person);

        $this->setExpectedException('LogicException', 'This person is already associated with another parent');
        $parent2->addChild($this->person);
    }

    public function testGetChildren()
    {
        $parent1 = new PersonStub();

        $parent1->addChild($this->person);

        $this->assertEquals($this->person, $parent1->getChildren()[0]);
    }

    public function testGetFiltered()
    {
        $testCollection = new ArrayCollection();
        $testActiveCollection = new ArrayCollection();

        unset($this->person->{'warnings'});
        $this->assertEmpty($this->person->getWarnings()->toArray());
        $warning1 = (new Warning())->setWarningText('Test Warning 1')->setSystemStatus(true);
        $testCollection->add($warning1);
        $testActiveCollection->add($warning1);

        $warning2 = (new Warning())->setWarningText('Test Warning 2')->setSystemStatus(true);
        $testCollection->add($warning2);
        $testActiveCollection->add($warning2);

        $warning3 = (new Warning())->setWarningText('Test Warning 3')->setSystemStatus(false);
        $testCollection->add($warning3);

        $this->person->setWarnings($testCollection);

        $this->assertEquals($testCollection, $this->person->getWarnings());

        $this->assertEquals($testActiveCollection->toArray(), $this->person->getActiveWarnings());
    }

    public function testPersonCanHaveDocuments()
    {
        $collection = new ArrayCollection();
        $collection->add(new IncomingDocument());
        $collection->add(new IncomingDocument());
        $collection->add(new OutgoingDocument());
        $collection->add(new OutgoingDocument());

        $this->person->setDocuments($collection);

        $this->assertCount(2, $this->person->getIncomingDocuments()->toArray());
        $this->assertCount(2, $this->person->getOutgoingDocuments()->toArray());
    }

    public function testPersonCanHaveTasks()
    {
        $collection = new ArrayCollection();
        $collection->add(new Task());
        $collection->add(new Task());

        $this->person->setTasks($collection);

        $this->assertCount(2, $this->person->getTasks()->toArray());
    }

    public function testPersonCanHaveNotes()
    {
        $collection = new ArrayCollection();
        $collection->add(new Note());
        $collection->add(new Note());

        $this->person->setNotes($collection);

        $this->assertCount(2, $this->person->getNotes()->toArray());
    }

    public function testRequiresCorrespondenceByPost()
    {
        $this->assertFalse($this->person->requiresCorrespondenceByPost());
        $this->assertTrue($this->person->setCorrespondenceByPost(true)->requiresCorrespondenceByPost());
    }

    public function testRequiresCorrespondenceByPhone()
    {
        $this->assertFalse($this->person->requiresCorrespondenceByPhone());
        $this->assertTrue($this->person->setCorrespondenceByPhone(true)->requiresCorrespondenceByPhone());
    }

    public function testRequiresCorrespondenceByEmail()
    {
        $this->assertFalse($this->person->requiresCorrespondenceByEmail());
        $this->assertTrue($this->person->setCorrespondenceByEmail(true)->requiresCorrespondenceByEmail());
    }

    public function testRequiresCorrespondence()
    {
        $this->assertFalse($this->person->requiresCorrespondence());
        $this->assertTrue($this->person->setCorrespondenceByEmail(true)->requiresCorrespondence());
    }


    public function testSetGetCreatedDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->person->getCreatedDate());

        $this->person->setCreatedDate();
        $this->assertNotEmpty($this->person->getCreatedDate());

        $this->person->setCreatedDate($expectedDate);
        $this->assertEquals($expectedDate, $this->person->getCreatedDate());
    }

  }
