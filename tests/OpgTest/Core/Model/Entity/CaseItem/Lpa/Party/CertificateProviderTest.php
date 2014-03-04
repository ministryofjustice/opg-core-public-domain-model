<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;

class CertificateProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CertificateProvider
     */
    private $certificateProvider;
   
    public function setUp()
    {
        $this->certificateProvider = new CertificateProvider();
    }
    
    public function testSetGetStatementType()
    {
        $expected = 'They have known me for a long time';
        
        $this->certificateProvider->setCertificateProviderStatementType($expected);
    
        $this->assertEquals(
            $expected,
            $this->certificateProvider->getCertificateProviderStatementType()
        );
    }
    
    public function testSetGetStatement()
    {
        $expected = 'I have known the donor for a long time';
    
        $this->certificateProvider->setStatement($expected);
    
        $this->assertEquals(
            $expected,
            $this->certificateProvider->getStatement()
        );
    }
}
