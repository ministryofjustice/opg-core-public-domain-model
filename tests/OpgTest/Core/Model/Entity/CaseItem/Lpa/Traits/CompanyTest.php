<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Traits;

use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company as CompanyTrait;

class CompanyTest extends \PHPUnit_Framework_TestCase
{
    use CompanyTrait;
    
    public function testSetGetCompanyName()
    {
        $expected = 'Trust Corporation Limited';
        
        $this->setCompanyName($expected);
        $this->assertEquals(
            $expected,
            $this->getCompanyName()
        );
    }
    
    public function testSetGetCompanyNumber()
    {
        $expected = '12345678';
    
        $this->setCompanyNumber($expected);
        $this->assertEquals(
            $expected,
            $this->getCompanyNumber()
        );
    }
}
