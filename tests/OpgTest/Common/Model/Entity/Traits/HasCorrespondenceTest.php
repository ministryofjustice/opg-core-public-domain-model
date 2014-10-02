<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\HasDocuments;
use Opg\Core\Model\Entity\Document\Document;
use Opg\Core\Model\Entity\Document\IncomingDocument;
use Opg\Core\Model\Entity\Document\OutgoingDocument;

/**
 * HasCorrespondence trait test.
 */
class HasCorrespondenceTest extends \PHPUnit_Framework_TestCase
{
    use HasDocuments;

    public function setUp()
    {
        $this->documents = new ArrayCollection();
    }

    public function testSetup()
    {
        $this->documents = null;
        $this->assertTrue($this->getOutgoingDocuments() instanceof ArrayCollection);

        $this->documents = null;
        $this->assertTrue($this->getIncomingDocuments() instanceof ArrayCollection);
    }

    public function testGetSetIncomingDocuments()
    {
        $correspondence = new IncomingDocument();
        $correspondence->setId(1);

        $this->documents = null;
        $this->assertNull($this->documents);

        $this->addDocument($correspondence);
        $this->assertEquals($this->documents, $this->getIncomingDocuments());
    }

    public function testGetSetOutgoingDocuments()
    {
        $correspondence = new OutgoingDocument();
        $correspondence->setId(1);

        $this->documents = null;
        $this->assertNull($this->documents);

        $this->addDocument($correspondence);
        $this->assertEquals($this->documents, $this->getOutgoingDocuments());
    }

    public function testAddDocumentsPreservesCorrespondence()
    {
        $documents = new ArrayCollection();
        $documents->add((new IncomingDocument())->setId(1));
        $documents->add((new IncomingDocument())->setId(2));
        $this->assertCount(2, $documents->toArray());

        $correspondence = new ArrayCollection();
        $correspondence->add((new OutgoingDocument())->setId(3));
        $correspondence->add((new OutgoingDocument())->setId(4));

        $this->setOutgoingDocuments($correspondence);
        $this->assertEquals(2, $this->documents->count());

        $retCor = $this->getOutgoingDocuments();
        $this->assertCount(2, $retCor->toArray());
        $this->assertCount(2, $correspondence->toArray());
        foreach($correspondence->toArray() as $correspondenceItem) {
            $this->assertTrue($retCor->contains($correspondenceItem));
        }
        $this->setIncomingDocuments($documents);
        $this->assertEquals(4, $this->documents->count());

        $retDoc = $this->getIncomingDocuments();
        $this->assertCount(2, $retDoc->toArray());
        $this->assertCount(2, $documents->toArray());

        foreach($documents->toArray() as $documentItem) {
            $this->assertTrue($retDoc->contains($documentItem));
        }

        $this->setOutgoingDocuments($correspondence);
        $this->assertEquals(4, $this->documents->count());

        $retCor = $this->getOutgoingDocuments();
        $this->assertCount(2, $retCor->toArray());
        $this->assertCount(2, $correspondence->toArray());
        foreach($correspondence->toArray() as $correspondenceItem) {
            $this->assertTrue($retCor->contains($correspondenceItem));
        }

        $this->setDocuments($documents);

        $this->assertEquals($this->getDocuments(Document::DIRECTION_INCOMING), $documents);
        $this->assertNotEquals($this->getDocuments(Document::DIRECTION_OUTGOING), $documents);

        $this->documents = null;
        $this->assertEmpty($this->getDocuments()->toArray());
    }
}
