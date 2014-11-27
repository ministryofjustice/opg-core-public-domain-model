<?php

namespace OpgTest\Core\Model\Entity\CaseActor;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\NonCaseContact;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

class NoneCaseContactTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NonCaseContact
     */
    protected $ncc;

    public function setUp()
    {
        $this->ncc = new NonCaseContact();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->ncc instanceof NonCaseContact);
    }

    public function testGetSetNames()
    {
        $expectedTitle = 'A';
        $expectedFirstName = 'Martin';
        $expectedMiddlename = 'Luther II';
        $expectedSurname   = 'King';
        $expectedFullname = implode(' ', array($expectedFirstName, $expectedMiddlename, $expectedSurname));

        $this->assertTrue($this->ncc->setTitle($expectedTitle) instanceof NonCaseContact);
        $this->assertTrue($this->ncc->setFirstname($expectedFirstName) instanceof NonCaseContact);
        $this->assertTrue($this->ncc->setSurname($expectedSurname) instanceof NonCaseContact);

        $this->assertEquals($expectedTitle, $this->ncc->getSalutation());
        $this->assertEquals($expectedFirstName, $this->ncc->getFirstname());
        $this->assertEquals($expectedSurname, $this->ncc->getSurname());

        $this->assertTrue($this->ncc->setFullname($expectedFullname) instanceof NonCaseContact);
        $this->assertEquals($expectedFullname, $this->ncc->getFullname());
        $this->assertEquals($expectedFirstName, $this->ncc->getFirstname());
        $this->assertEquals($expectedSurname, $this->ncc->getSurname());
        $this->assertEquals($expectedMiddlename, $this->ncc->getMiddlename());

        $this->assertTrue($this->ncc->setFullname(null) instanceof NonCaseContact);
        $this->assertEquals($expectedFullname, $this->ncc->getFullname());

        $this->assertTrue($this->ncc->setFullname($expectedSurname) instanceof NonCaseContact);
        $this->assertEquals($expectedSurname, $this->ncc->getSurname());
    }

    public function testAddCase()
    {
        $case = new Lpa();
        $this->ncc->addCase($case);
        $this->assertCount(0, $this->ncc->getCases()->toArray());
    }

    public function testAddCases()
    {
        $this->assertEmpty($this->ncc->getCases()->count());
        $cases = new ArrayCollection();
        $this->ncc->setCases($cases);
        $this->assertCount(0, $this->ncc->getCases()->toArray());
    }
}
