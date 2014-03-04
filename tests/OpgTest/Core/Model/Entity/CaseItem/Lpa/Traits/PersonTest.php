<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Traits;

use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Person as PersonTrait;

/**
 * ToArray test case.
 */
class PersonTest extends \PHPUnit_Framework_TestCase
{
    use PersonTrait;

    public function testGetSetDob()
    {
        $expected = '1993-11-22';
        
        $this->setDob($expected);
    
        $this->assertEquals(
            $expected,
            $this->getDob()
        );
    }
    
    public function testGetSetTitle()
    {
        $expected = 'Mrs';
    
        $this->setTitle($expected);
    
        $this->assertEquals(
            $expected,
            $this->getTitle()
        );
    }
    
    public function testGetSetFirstname()
    {
        $expected = 'Jane';
    
        $this->setFirstname($expected);
    
        $this->assertEquals(
            $expected,
            $this->getFirstname()
        );
    }
    
    public function testGetSetMiddlenames()
    {
        $expected = 'Snow White';
    
        $this->setMiddlename($expected);
    
        $this->assertEquals(
            $expected,
            $this->getMiddlename()
        );
    }
    
    public function testGetSetSurname()
    {
        $expected = 'Smith';
    
        $this->setSurname($expected);
    
        $this->assertEquals(
            $expected,
            $this->getSurname()
        );
    }
}
