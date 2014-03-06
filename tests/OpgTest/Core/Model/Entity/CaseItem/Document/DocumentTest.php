<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Document;

use Doctrine\Common\Collections\ArrayCollection;

use Opg\Core\Model\Entity\CaseItem\Page\Page;
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
        'pages'         => array(),
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
        $pageCollection = new ArrayCollection();

        for($i=0; $i<10; $i++) {
            $page = new Page();
            $page->setId($i+1)->setPageNumber($i+1);
            $pageCollection->add($page);
        }

        $this->data['pages'] = $pageCollection->toArray();
        $this->data['metadata']['numberOfPages'] = count($this->data['pages']);
        $this->document = $this->document->exchangeArray($this->data);

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

    public function testAddGetPageCollection()
    {
        $page = new Page();
        $this->document->addPage($page);
        $pages = $this->document->getPages()->toArray();
        $this->assertEquals($pages[1], $page);

        $pageCollection = $this->document->getPages();
        $pageCollection->add($page);


        $this->assertEquals($pageCollection, $this->document->getPages());
    }

    public function testSetGetPageCollection()
    {
        $pageCollection = new ArrayCollection();
        $pageCollection->add(new Page);
        $pageCollection->add(new Page);

        $this->document->setPages($pageCollection);

        $this->assertEquals(count($pageCollection), count($this->document->getPages()));
    }

    public function testSetGetFileName()
    {
        $filename = 'TestFile';
        $this->document->setFilename($filename);
        $this->assertEquals($filename, $this->document->getFilename());
    }
}
