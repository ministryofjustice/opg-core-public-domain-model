<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;

/**
 * ToArray test case.
 */
class AttorneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Attorney
     */
    private $attorney;
   
    public function setUp()
    {
        $this->attorney = new Attorney();
    }
    
    public function testSetGetRelationshipToDonor()
    {
        $expected = 'Test Relationship';
        
        $this->attorney->setRelationshipToDonor($expected);
        $this->assertEquals(
            $expected,
            $this->attorney->getRelationshipToDonor()
        );
    }
    
    public function testSetGetOccupation()
    {
        $expected = 'Test Occupation';
    
        $this->attorney->setOccupation($expected);
        $this->assertEquals(
            $expected,
            $this->attorney->getOccupation()
        );
    }
    
    public function testSetGetIsTrustCorporation()
    {
        $this->attorney->setIsTrustCorporation(true);
        $this->assertTrue($this->attorney->isTrustCorporation());
        
        $this->attorney->setIsTrustCorporation(false);
        $this->assertFalse($this->attorney->isTrustCorporation());
    }
    
    public function testSetGetIsReplacementAttorney()
    {
        $this->attorney->setIsReplacementAttorney(true);
        $this->assertTrue($this->attorney->isReplacementAttorney());
    
        $this->attorney->setIsReplacementAttorney(false);
        $this->assertFalse($this->attorney->isReplacementAttorney());
    }
}
