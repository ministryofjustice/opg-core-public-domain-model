<?php

namespace OpgTest\Core\Model\Entity\Warning;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\Assignable\User;
use Opg\Core\Model\Entity\Warning\Warning;
use Zend\InputFilter\InputFilter;

class WarningStub extends  Warning
{
    public function __unset($property)
    {
        if (property_exists(get_class($this), $property)) {
            $this->{$property} = null;
        }
    }
}

class WarningTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Warning
     */
    protected $warning;

    public function setUp()
    {
        $this->warning = new WarningStub();
    }

    public function testSetup()
    {
        $this->assertTrue($this->warning instanceof Warning);
        unset($this->warning->{'dateAdded'});
        $this->assertEmpty($this->warning->getDateAddedString());
    }

    public function testGetSetId()
    {
        $expected = 1;
        $this->assertEmpty($this->warning->getId());

        $this->assertEquals(
            $expected,
            $this->warning->setId($expected)->getId()
        );
    }

    public function testGetSetWarningType()
    {
        $expected = 'Behavioural Warning';

        $this->assertEmpty($this->warning->getWarningType());

        $this->assertEquals(
            $expected,
            $this->warning->setWarningType($expected)->getWarningType()
        );
    }

    public function testGetSetAddedBy()
    {
        $expected = (new User())->setId(1)->setFirstname('Bob');

        $this->assertEmpty($this->warning->getAddedBy());

        $this->assertEquals(
            $expected,
            $this->warning->setAddedBy($expected)->getAddedBy()
        );
    }

    public function testGetSetClosedBy()
    {
        $expected = (new User())->setId(1)->setFirstname('Fred');

        $this->assertEmpty($this->warning->getClosedBy());

        $this->assertEquals(
            $expected,
            $this->warning->setClosedBy($expected)->getClosedBy()
        );
    }

    public function testGetSetDateAdded()
    {
        $expected = DateFormat::createDateTime('01/01/2014 00:00:01');

        $now = new \DateTime();

        $this->assertEquals($now, $this->warning->getDateAdded());

        $this->assertEquals(
            $expected,
            $this->warning->setDateAdded($expected)->getDateAdded()
        );
    }

    public function testGetSetDateAddedString()
    {
        $expected = "01/01/2014";

        $now = date('d/m/Y');

        $this->assertEquals($now, $this->warning->getDateAddedString());
        $this->assertTrue($this->warning->setDateAddedString('') instanceof Warning);
        $this->assertEquals($now, $this->warning->getDateAddedString());

        $this->assertEquals(
            $expected,
            $this->warning->setDateAddedString($expected)->getDateAddedString()
        );
    }

    public function testGetSetDateClosed()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->warning->getDateClosed());

        $this->assertEquals(
            $expected,
            $this->warning->setDateClosed($expected)->getDateClosed()
        );
    }

    public function testGetSetDateClosedString()
    {
        $expected = "01/01/2014";

        $this->assertEmpty($this->warning->getDateClosedString());
        $this->assertTrue($this->warning->setDateClosedString('') instanceof Warning);
        $this->assertEmpty($this->warning->getDateClosedString());

        $this->assertEquals(
            $expected,
            $this->warning->setDateClosedString($expected)->getDateClosedString()
        );
    }

    public function testGetSetWarningText()
    {
        $expected =
            "Capt. Malcolm Reynolds: What in the hell happened back there?
            Hoban 'Wash' Washburn: Start with the part where Jayne gets knocked out by a 90-pound girl
            'cause... I don't think that's ever getting old.";

        $this->assertEmpty($this->warning->getWarningText());

        $this->assertEquals(
            $expected,
            $this->warning->setWarningText($expected)->getWarningText()
        );
    }

    public function getSetStatus()
    {
        $this->assertTrue($this->warning->isActive());

        $this->assertFalse($this->warning->setSystemStatus(false)->isActive());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage This warning is already associated with a person
     */
    public function testGetSetPerson()
    {
        $expected = (new Donor())
            ->setId(1)
            ->setFirstName('Bob');

        $this->assertEmpty($this->warning->getPerson());

        $this->assertEquals($expected, $this->warning->setPerson($expected)->getPerson());

        //Throw us an exception here
        $this->warning->setPerson(new Donor());
    }

    public function testGetInputFilter()
    {
        $this->assertTrue($this->warning->getInputFilter() instanceof InputFilter);
    }

    public function testGetIterator()
    {
        $this->assertTrue($this->warning->getIterator() instanceof \Traversable);
    }

    public function testWarningIsValid()
    {
        $this->assertFalse($this->warning->isValid());

        $this->warning->setWarningType('Test');
        $this->assertFalse($this->warning->isValid());

        $this->warning->setWarningText('Test');
        $this->assertTrue($this->warning->isValid());

    }
}
