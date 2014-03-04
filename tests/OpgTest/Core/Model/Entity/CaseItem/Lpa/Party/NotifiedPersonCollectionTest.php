<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPersonCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;

/**
 * NotifiedPerson test case.
 */
class NotifiedPersonCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var NotifiedPersonCollection
     */
    private $notifiedPersonCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->notifiedPersonCollection = new NotifiedPersonCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->notifiedPerson = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoNotifiedPersonsAdded()
    {
        $expected = [];
        $actual = $this->notifiedPersonCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $notifiedPerson = new NotifiedPerson();
            
            $notifiedPerson->setId($i);
            
            $this->notifiedPersonCollection->addNotifiedPerson(
                $notifiedPerson
            );
        }
        
        $notifiedPerson = new NotifiedPerson();
        
        $this->notifiedPersonCollection->addNotifiedPerson(
            $notifiedPerson
        );
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
        
        $this->assertEquals(
            $this->notifiedPersonCollection->getData(),
            $this->notifiedPersonCollection->getNotifiedPersonCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->notifiedPersonCollection->toArray();
        
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
        $iterator = $this->notifiedPersonCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->notifiedPersonCollection->exchangeArray([]);
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->notifiedPersonCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
