<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Document;

use Opg\Core\Model\Entity\CaseItem\Document\DocumentCollection;
use Opg\Core\Model\Entity\CaseItem\Document\Document;

/**
 * Document test case.
 */
class DocumentCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var DocumentCollection
     */
    private $documentCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
                
        $this->documentCollection = new DocumentCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->document = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testGetInputFilter()
    {
        $inputFilter = $this->documentCollection->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

    public function testReturnsEmptyArrayWhenNoDocumentsAdded()
    {
        $expected = [];
        $actual = $this->documentCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $document = new Document();
            $document->setId($i);
            
            $this->documentCollection->addDocument(
                $document
            );
        }
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
        
        $this->assertEquals(
            $this->documentCollection->getData(),
            $this->documentCollection->getDocumentCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->documentCollection->toArray();
        
        $expected = 10;
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
        $iterator = $this->documentCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->documentCollection->exchangeArray([]);
    }
}
