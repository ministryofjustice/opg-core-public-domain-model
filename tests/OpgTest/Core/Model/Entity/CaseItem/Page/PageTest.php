<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Page;

use Opg\Core\Model\Entity\CaseItem\Document\Document;
use PHPUnit_Framework_TestCase;
use Opg\Core\Model\Entity\CaseItem\Page\Page;

class PageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Opg\Core\Model\Entity\CaseItem\Page\Page
     */
    private $page;

    private $data = array(
        'id'           => 'abc123',
        'pageNumber'   => 1,
        'document'     => null,
        'thumbnail'    => 'http://thumbnail.abc.com',
        'main'         => 'http://main.abc.com',
        'text'         => 'testtext',
        'errorMessages' => array()
    );

    public function setUp()
    {
        $this->page = new Page();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseItem\Page\Page', $this->page);
    }

    public function testExchangeAndToArray()
    {
        $this->page->exchangeArray($this->data);

        $this->assertEquals($this->data, $this->page->toArray());

    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->page->getIterator());

        $this->page->exchangeArray($this->data);
        $this->assertEquals($this->data, $this->page->getIterator()->getArrayCopy());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->page->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

    public function testGetSetId()
    {
        $this->page->setId($this->data['id']);

        $this->assertEquals($this->data['id'], $this->page->getId());
    }

    public function testGetSetPageNumber()
    {
        $this->page->setPageNumber($this->data['pageNumber']);

        $this->assertEquals($this->data['pageNumber'], $this->page->getPageNumber());
    }

    public function testGetSetThumbernail()
    {
        $this->page->setThumbnail($this->data['thumbnail']);

        $this->assertEquals($this->data['thumbnail'], $this->page->getThumbnail());
    }

    public function testGetSetMain()
    {
        $this->page->setMain($this->data['main']);

        $this->assertEquals($this->data['main'], $this->page->getMain());
    }

    public function testGetSetText()
    {
        $expectedText = 'Test Text';

        $this->page->setText($expectedText);
        $this->assertEquals($this->page->getText(), $expectedText);
    }

    public function testGetSetDocument()
    {
        $expectedDocument = new Document();

        $this->page->setDocument($expectedDocument);

        $this->assertEquals($expectedDocument, $this->page->getDocument());

        try {
            $this->page->setDocument($expectedDocument);
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
        }
    }
}
