<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProviderCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;

/**
 * CertificateProvider test case.
 */
class CertificateProviderCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CertificateProviderCollection
     */
    private $certificateProviderCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->certificateProviderCollection = new CertificateProviderCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->certificateProvider = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoCertificateProvidersAdded()
    {
        $expected = [];
        $actual = $this->certificateProviderCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $certificateProvider = new CertificateProvider();
            
            $certificateProvider->setId($i);
            
            $this->certificateProviderCollection->addCertificateProvider(
                $certificateProvider
            );
        }
        
        $certificateProvider = new CertificateProvider();
        
        $this->certificateProviderCollection->addCertificateProvider(
            $certificateProvider
        );
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
        
        $this->assertEquals(
            $this->certificateProviderCollection->getData(),
            $this->certificateProviderCollection->getCertificateProviderCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->certificateProviderCollection->toArray();
        
        $expected = 11;
        $actual = count($array);
        
        $this->assertEquals(
            $expected,
            $actual
        );
        
        for ($i=0; $i<10; $i++) {
            $this->assertEquals(
                $i,
                $array[$i]['id']
            );
        }
    }
    
    public function testGetIterator()
    {
        $iterator = $this->certificateProviderCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->certificateProviderCollection->exchangeArray([]);
    }

    public function testGetInputFilter()
    {
        $inputFilter = $this->certificateProviderCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
