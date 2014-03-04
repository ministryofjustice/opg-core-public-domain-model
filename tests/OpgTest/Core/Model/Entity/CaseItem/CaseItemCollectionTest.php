<?php
namespace OpgTest\Core\Model\Entity\CaseItem\CaseItem;

use Opg\Core\Model\Entity\CaseItem\CaseItemCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

/**
 * CaseItem test case.
 */
class CaseItemCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var CaseItemCollection
     */
    private $caseItemCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
                
        $this->caseItemCollection = new CaseItemCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->caseItem = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoCaseItemsAdded()
    {
        $expected = [];
        $actual = $this->caseItemCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $caseItem = new Lpa();
            $caseItem->setCaseId($i);
    
            $this->caseItemCollection->addCaseItem(
                $caseItem
            );
        }
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
    
        $this->assertEquals(
            $this->caseItemCollection->getData(),
            $this->caseItemCollection->getCaseItemCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->caseItemCollection->toArray();
    
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
        $iterator = $this->caseItemCollection->getIterator();
        
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
        
        $this->caseItemCollection->exchangeArray($data);
        
        $array = $this->caseItemCollection->getCaseItemCollection();
        
        $this->assertEquals(
            count($data['cases']),
            count($array)
        );
        
        foreach ($array as $element) {
            $this->assertInstanceOf(
                'Opg\Core\Model\Entity\CaseItem\CaseItemInterface',
                $element
            );
        }
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->caseItemCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
