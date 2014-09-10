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

        $this->assertTrue($this->ncc->setTitle($expectedTitle) instanceof NonCaseContact);
        $this->assertTrue($this->ncc->setFirstname($expectedFirstName) instanceof NonCaseContact);
        $this->assertTrue($this->ncc->setSurname($expectedSurname) instanceof NonCaseContact);
        
        $this->assertEquals($expectedTitle, $this->ncc->getSalutation());
        $this->assertEquals($expectedFirstName, $this->ncc->getFirstname());
        $this->assertEquals($expectedSurname, $this->ncc->getSurname());
        
        $this->assertTrue($this->ncc->setFullname(implode(' ', array($expectedFirstName, $expectedMiddlename, $expectedSurname))) instanceof NonCaseContact);
        $this->assertEquals($expectedFirstName, $this->ncc->getFirstname());
        $this->assertEquals($expectedSurname, $this->ncc->getSurname());
        $this->assertEquals($expectedMiddlename, $this->ncc->getMiddlename());
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddCase()
    {
        $case = new Lpa();
        $this->ncc->addCase($case);
    }

    /**
     * @expectedException \LogicException
     */
    public function testAddCases()
    {
        $this->assertEmpty($this->ncc->getCases());
        $cases = new ArrayCollection();
        $this->ncc->setCases($cases);
    }
}
