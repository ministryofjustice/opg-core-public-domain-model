<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Page;

use Opg\Core\Model\Entity\CaseItem\Page\PageCollection;
use Opg\Core\Model\Entity\CaseItem\Page\Page;

/**
 * Page test case.
 */
class PageCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PageCollection
     */
    private $pageCollection;

    public function setUp()
    {
        $this->pageCollection = new PageCollection();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseItem\Page\PageCollection', $this->pageCollection);
    }

    public function testGetIterator()
    {
        $iterator = $this->pageCollection->getIterator();

        $this->assertInstanceOf('ArrayIterator', $iterator);
    }

    public function testGetInputFilter()
    {
        $inputFilter = $this->pageCollection->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

    public function testGetData()
    {
        $this->assertEquals(array(), $this->pageCollection->getData());
    }

    public function testGetPageCollection()
    {
        $this->assertEquals(array(), $this->pageCollection->getData());
    }

    public function testAddPage()
    {
        $page = new Page();

        $this->pageCollection->addPage($page);

        $this->assertEquals(1, count($this->pageCollection->getData()));
        $this->assertEquals(1, count($this->pageCollection->getPageCollection()));
    }

    public function testToArray()
    {
        $page = new Page();
        $page->setId(123)
            ->setPageNumber(5)
            ->setThumbnail('thumbnail.page.com')
            ->setText('testtext')
            ->setMain('main.page.com');

        $this->pageCollection->addPage($page);

        $expected = array(
            'id'            => '123',
            'pageNumber'    => 5,
            'thumbnail'     => 'thumbnail.page.com',
            'main'          => 'main.page.com',
            'text'          => 'testtext',
            'errorMessages' => array()
        );

        $this->assertEquals(array($expected), $this->pageCollection->toArray());
    }

    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->pageCollection->exchangeArray([]);
    }
}