<?php
namespace OpgTest\Core\Model\Entity\Documents;

use Doctrine\Common\Collections\ArrayCollection;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Core\Model\Entity\CaseActor\NonCaseContact;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa;
use Opg\Core\Model\Entity\Document\Page\Page;
use Opg\Core\Model\Entity\Document\Document;
use Opg\Core\Model\Entity\Assignable\User;
use PHPUnit_Framework_TestCase;
use Opg\Core\Model\Entity\Document\IncomingDocument;

class IncomingDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var IncomingDocument
     */
    private $document;

    private $data = array(
        'id'            => 123,
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
        'createdDate'   => null,
        'direction'     => IncomingDocument::DOCUMENT_INCOMING_CORRESPONDENCE
    );

    public function setUp()
    {
        $this->document = new IncomingDocument();
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->document->getIterator());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->document->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
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

    public function testGetCreatedDateWithNull()
    {
        $this->assertTrue($this->document->setCreatedDate() instanceof Document);
        $this->assertNotEmpty($this->document->getCreatedDate());
        $this->assertNotEmpty($this->document->getDateTimeAsString('createdDate'));
    }

    public function testGetCreatedDate()
    {
        $expected = '01/01/2014 00:00:00';

        $expectedDate = \DateTime::createFromFormat(DateFormat::getDateTimeFormat(), $expected);

        $this->assertTrue($this->document->setCreatedDate($expectedDate) instanceof Document);
        $this->assertEquals($expectedDate, $this->document->getCreatedDate());
        $this->assertEquals($expected, $this->document->getDateTimeAsString('createdDate'));
    }

    public function testGetSetSourceDocumentType()
    {
        $expected = 'napkin';

        $this->assertEmpty($this->document->getSourceDocumentType());

        $this->assertTrue($this->document->setSourceDocumentType($expected) instanceof Document);

        $this->assertEquals($expected, $this->document->getSourceDocumentType());
    }

    public function testGetSetCaseId()
    {
        $expected = 111;

        $this->assertNull($this->document->getCase());
        $this->assertTrue($this->document->setCase((new Lpa())->setId($expected)) instanceof Document);

        $this->assertEquals($expected, $this->document->getCase()->getId());
    }

    public function testGetSetDirection()
    {
        $expected = 'Outgoing';

        $this->assertNotEquals($expected, $this->document->getDirection());
        $this->assertEquals($expected, $this->document->setDirection($expected)->getDirection());

        $this->assertEquals(Document::DIRECTION_INCOMING,$this->document->setDirection(Document::DIRECTION_INCOMING)->getDirection());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetSetCorrespondent()
    {
        $correspondent = (new NonCaseContact())->setId(1);

        $this->assertNull($this->document->getCorrespondent());
        $this->assertEquals($correspondent, $this->document->setCorrespondent($correspondent)->getCorrespondent());
        $this->assertEquals($correspondent, $this->document->setCorrespondent($correspondent)->getCorrespondent());
    }

    public function testGetSetDescription()
    {
        $expected =
            "Bacon ipsum dolor sit amet bresaola porchetta chicken tri-tip. Chuck venison tri-tip ground round corned
             beef shankle fatback. Sirloin chicken doner t-bone. Andouille kielbasa sausage pork belly biltong drumstick
             ribeye fatback hamburger corned beef shoulder leberkas.";

        $this->assertNull($this->document->getDescription());
        $this->assertEquals($expected, $this->document->setDescription($expected)->getDescription());
    }

    public function testGetSetAssignee()
    {
        $user = (new User())->setId(2);

        $this->assertNull($this->document->getAssignee());
        $this->assertEquals($user, $this->document->setAssignee($user)->getAssignee());

    }

    public function testGetSetFriendlyDescription()
    {
        $expected = 'Test Document';
        $this->assertEmpty($this->document->getFriendlyDescription());

        $this->assertEquals($expected, $this->document->setFriendlyDescription($expected)->getFriendlyDescription());
    }
}
