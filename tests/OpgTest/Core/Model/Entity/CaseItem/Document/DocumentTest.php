<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Document;

use Opg\Core\Model\Entity\CaseItem\Page\PageCollection;
use PHPUnit_Framework_TestCase;
use Opg\Core\Model\Entity\CaseItem\Document\Document;

class DocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Opg\Core\Model\Entity\CaseItem\Document\Document
     */
    private $document;

    private $data = array(
        'id'            => '123',
        'type'          => 'doctype',
        'subtype'       => 'docsubtype',
        'title'         => 'doc title',
        'pages'         => null,
        'errorMessages' => array(),
        'metadata' => array( 
            'filename' => 'filename',
            'documentType' => 'doctype',
            'numberOfPages' => 0
        ),
    );

    public function setUp()
    {
        $this->document = new Document();
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->document->getIterator());

        $this->document->exchangeArray($this->data);
        $this->assertEquals($this->data, $this->document->getIterator()->getArrayCopy());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->document->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

    public function testExchangeAndToArray()
    {
        $this->document->exchangeArray($this->data);

        $this->assertEquals($this->data, $this->document->toArray());
    }

    public function testSetGetId()
    {
        $this->document->setId($this->data['id']);

        $this->assertEquals($this->data['id'], $this->document->getId());
    }

    public function testSetGetType()
    {
        $this->document->setType($this->data['type']);

        $this->assertEquals($this->data['type'], $this->document->getType());
    }

    public function testSetGetSubtype()
    {
        $this->document->setSubtype($this->data['subtype']);

        $this->assertEquals($this->data['subtype'], $this->document->getSubtype());
    }

    public function testSetGetTitle()
    {
        $this->document->setTitle($this->data['title']);

        $this->assertEquals($this->data['title'], $this->document->getTitle());
    }

    public function testSetGetPageCollection()
    {
        $pageCollection = new PageCollection();

        $this->document->setPageCollection($pageCollection);

        $this->assertEquals($pageCollection, $this->document->getPageCollection());
    }
}
