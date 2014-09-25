<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\HasCorrespondence as HasCorrespondenceTrait;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\Correspondence\Correspondence as CorrespondenceEntity;

/**
 * HasCorrespondence trait test.
 */
class HasCorrespondenceTest extends \PHPUnit_Framework_TestCase
{
    use HasCorrespondenceTrait;

    protected $correspondence;

    public function setUp()
    {
        $this->correspondence = new ArrayCollection();
    }

    public function testGetCorrespondence()
    {
        $correspondence = new CorrespondenceEntity();
        $correspondence->setId(1);

        $this->correspondence->add($correspondence);
        $this->assertEquals($this->correspondence, $this->getCorrespondence());
    }

    public function testSetNotes()
    {
        $correspondence1 = new CorrespondenceEntity();
        $correspondence1->setId(1);

        $correspondence2 = new CorrespondenceEntity();
        $correspondence2->setId(2);

        $correspondence3 = new CorrespondenceEntity();
        $correspondence3->setId(3);

        $correspondence = new ArrayCollection();
        $correspondence->add($correspondence1);
        $correspondence->add($correspondence2);
        $correspondence->add($correspondence3);

        $this->setCorrespondence($correspondence);

        $this->assertEquals($correspondence, $this->correspondence);
    }


    public function testAddNote()
    {
        $correspondence1 = new CorrespondenceEntity();
        $correspondence1->setId(1);

        $this->addCorrespondence($correspondence1);

        $this->assertSame($correspondence1, $this->correspondence->get(0));

        // Add a second note
        $correspondence2 = new CorrespondenceEntity();
        $correspondence2->setId(2);

        $this->addCorrespondence($correspondence2);

        $this->assertEquals($correspondence1, $this->correspondence->get(0));
        $this->assertEquals($correspondence2, $this->correspondence->get(1));
    }

    public function testAddDocumentsPreservesCorrespondence()
    {
        $documents = new ArrayCollection();
        $documents->add((new Document())->setId(1));
        $documents->add((new Document())->setId(2));
        $this->assertCount(2, $documents->toArray());

        $correspondence = new ArrayCollection();
        $correspondence->add((new CorrespondenceEntity())->setId(3));
        $correspondence->add((new CorrespondenceEntity())->setId(4));

        $this->setCorrespondence($correspondence);
        $this->assertEquals(2, $this->correspondence->count());

        $retCor = $this->getCorrespondence();
        $this->assertCount(2, $retCor->toArray());
        $this->assertCount(2, $correspondence->toArray());
        foreach($correspondence->toArray() as $correspondenceItem) {
            $this->assertTrue($retCor->contains($correspondenceItem));
        }
        $this->setDocuments($documents);
        $this->assertEquals(4, $this->correspondence->count());

        $retDoc = $this->getDocuments();
        $this->assertCount(2, $retDoc->toArray());
        $this->assertCount(2, $documents->toArray());

        foreach($documents->toArray() as $documentItem) {
            $this->assertTrue($retDoc->contains($documentItem));
        }

        $this->setCorrespondence($correspondence);
        $this->assertEquals(4, $this->correspondence->count());

        $retCor = $this->getCorrespondence();
        $this->assertCount(2, $retCor->toArray());
        $this->assertCount(2, $correspondence->toArray());
        foreach($correspondence->toArray() as $correspondenceItem) {
            $this->assertTrue($retCor->contains($correspondenceItem));
        }
    }
}
