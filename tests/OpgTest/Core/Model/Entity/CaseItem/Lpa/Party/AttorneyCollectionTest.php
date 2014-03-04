<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;

/**
 * Attorney test case.
 */
class AttorneyCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AttorneyCollection
     */
    private $attorneyCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->attorneyCollection = new AttorneyCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->attorney = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoAttorneysAdded()
    {
        $expected = [];
        $actual = $this->attorneyCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $attorney = new Attorney();
            
            $attorney->setId($i);
            
            $this->attorneyCollection->addAttorney(
                $attorney
            );
        }
        
        $attorney = new Attorney();
        
        $this->attorneyCollection->addAttorney(
            $attorney
        );
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
        
        $this->assertEquals(
            $this->attorneyCollection->getData(),
            $this->attorneyCollection->getAttorneyCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->attorneyCollection->toArray();
        
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
        $iterator = $this->attorneyCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->attorneyCollection->exchangeArray([]);
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->attorneyCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
