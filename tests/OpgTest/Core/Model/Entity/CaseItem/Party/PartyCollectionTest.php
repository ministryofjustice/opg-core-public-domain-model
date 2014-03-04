<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Party;

use Opg\Core\Model\Entity\CaseItem\Party\PartyCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;

/**
 * Party test case.
 */
class PartyCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PartyCollection
     */
    private $partyCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->partyCollection = new PartyCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->party = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoPartysAdded()
    {
        $expected = [];
        $actual = $this->partyCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $party = new Donor();
            
            $party->setId($i);
            
            $this->partyCollection->addParty(
                $party
            );
        }
        
        $party = new Attorney();
        
        $this->partyCollection->addParty(
            $party
        );
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
        
        $this->assertEquals(
            $this->partyCollection->getData(),
            $this->partyCollection->getPartyCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->partyCollection->toArray();
        
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
        $iterator = $this->partyCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->partyCollection->exchangeArray([]);
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->partyCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
