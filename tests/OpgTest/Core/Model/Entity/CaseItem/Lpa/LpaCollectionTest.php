<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\LpaCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

/**
 * Lpa test case.
 */
class LpaCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var LpaCollection
     */
    private $lpaCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
                
        $this->lpaCollection = new LpaCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->lpa = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoLpasAdded()
    {
        $expected = [];
        $actual = $this->lpaCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $lpa = new Lpa();
            $lpa->setCaseId($i);
    
            $this->lpaCollection->addLpa(
                $lpa
            );
        }
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
    
        $this->assertEquals(
            $this->lpaCollection->getData(),
            $this->lpaCollection->getLpaCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->lpaCollection->toArray();
    
        $expected = 10;
        $actual = count($array);
    
        $this->assertEquals(
            $expected,
            $actual
        );
    
        for ($i=0; $i<10; $i++) {
            $this->assertEquals(
                $i,
                $array[$i]['caseId']
            );
        }
    }
    
    public function testGetIterator()
    {
        $iterator = $this->lpaCollection->getIterator();
        
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testExchangeArray()
    {
        $data = [
            'cases' => [
                1,
                2,
                3,
            ],
        ];
        
        $this->lpaCollection->exchangeArray($data);
        
        $array = $this->lpaCollection->getLpaCollection();
        
        $this->assertEquals(
            count($data['cases']),
            count($array)
        );
        
        foreach ($array as $element) {
            $this->assertInstanceOf(
                'Opg\Core\Model\Entity\CaseItem\Lpa\Lpa',
                $element
            );
        }
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->lpaCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
