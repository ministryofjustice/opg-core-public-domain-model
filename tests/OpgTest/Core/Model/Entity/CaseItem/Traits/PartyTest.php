<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Traits;

use Opg\Core\Model\Entity\CaseItem\Traits\Party as PartyTrait;
use Opg\Core\Model\Entity\CaseItem\CaseItemCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

/**
 * ToArray test case.
 */
class PartyTest extends \PHPUnit_Framework_TestCase
{
    use PartyTrait;

    public function testSetGetId()
    {
        $expected = '123';
        
        $this->setId($expected);
        $this->assertEquals(
            $expected,
            $this->getId()
        );
    }
    
    public function testSetGetEmail()
    {
        $expected = 'test@example.com';
    
        $this->setEmail($expected);
        $this->assertEquals(
            $expected,
            $this->getEmail()
        );
    }
    
    public function testSetGetCases()
    {
        $this->setCases(new CaseItemCollection());
        $this->assertTrue(
            $this->getCases() instanceof CaseItemCollection
        );
    }

    public function testGetCases()
    {
        $this->assertTrue(
            $this->getCases() instanceof CaseItemCollection
        );
    }
    
    public function testAddCase()
    {
        $expected = new CaseItemCollection();
        $case = new Lpa();
        $case->setCaseId('TestId');
        $expected->addCaseItem($case);
        
        $this->addCase($case);
        $actual = $this->getCases();
                
        $this->assertEquals(
            $expected->getData(),
            $actual->getData()
        );
    }
}
