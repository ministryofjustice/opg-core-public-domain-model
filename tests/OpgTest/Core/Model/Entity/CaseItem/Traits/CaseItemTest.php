<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Traits;

use Opg\Core\Model\Entity\CaseItem\Note\NoteCollection;
use Opg\Core\Model\Entity\CaseItem\Traits\CaseItem as CaseItemTrait;
use \Opg\Core\Model\Entity\User\User;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Document\DocumentCollection;

/**
 * ToArray test case.
 */
class CaseItemTest extends \PHPUnit_Framework_TestCase
{
    use CaseItemTrait;

    public function testSetGetStatus()
    {
        $expected = 'Perfect';
        
        $this->setStatus($expected);
        $this->assertEquals(
            $expected,
            $this->getStatus()
        );
    }
    
    public function testSetGetExternalId()
    {
        $expected = '12345ABCDE-12345';
    
        $this->setExternalId($expected);
        $this->assertEquals(
            $expected,
            $this->getExternalId()
        );
    }
    
    public function testSetGetCaseType()
    {
        $expected = 'LPA';
    
        $this->setCaseType($expected);
        $this->assertEquals(
            $expected,
            $this->getCaseType()
        );
    }
    
    public function testSetGetCaseSubtype()
    {
        $expected = 'Health and Welfare';
    
        $this->setCaseSubtype($expected);
        $this->assertEquals(
            $expected,
            $this->getCaseSubtype()
        );
    }
    
    public function testSetGetDueDate()
    {
        $expected = '2014-09-25';
    
        $this->setDueDate($expected);
        $this->assertEquals(
            $expected,
            $this->getDueDate()
        );
    }   
    
    public function testSetGetAssignedUser()
    {
        $name = 'Testuser';
        $user = new User();
        $user->setRealname($name);
        
        $this->setAssignedUser($user);
        
        $this->assertEquals(
            $name,
            $this->getAssignedUser()->getRealname()
        );
    }
    
    public function testSetGetAddNotes()
    {
        // Adding individual Notes
        for ($i=0; $i<10; $i++) {
            $note = new Note();
            $note->setId($i);
            $this->addNote($note);
        }

        $expected = 10;
        $array = $this->getNoteCollection()->getNoteCollection();
        
        $this->assertEquals(
            $expected,
            count($array)
        );
        
        for ($i=0; $i<10; $i++) {
            $note = $array[$i];
            
            $this->assertEquals(
                $i,
                $note->getId()
            );
        }

        // Whole collection at once
        $notes = new NoteCollection();
        for ($i=10; $i<20; $i++) {
            $note = new Note();
            $note->setId($i);

            $notes->addNote($note);
        }
        $this->setNoteCollection($notes);

        $this->assertEquals($notes, $this->getNoteCollection());
    }
    
    public function testSetGetTasks()
    {
        for ($i=0; $i<10; $i++) {
            $task = new Task();
            $task->setId($i);
            $this->addTask($task);
        }
    
        $expected = 10;
        $array = $this->getTaskCollection()->getTaskCollection();
    
        $this->assertEquals(
            $expected,
            count($array)
        );
    
        for ($i=0; $i<10; $i++) {
            $task = $array[$i];
    
            $this->assertEquals(
                $i,
                $task->getId()
            );
        }
    }
    
    public function testSetGetAddDocuments()
    {
        for ($i=0; $i<10; $i++) {
            $document = new Document();
            $document->setId($i);
            $this->addDocument($document);
        }
    
        $expected = 10;
        $array = $this->getDocumentCollection()->getDocumentCollection();
    
        $this->assertEquals(
            $expected,
            count($array)
        );
    
        for ($i=0; $i<10; $i++) {
            $document = $array[$i];
    
            $this->assertEquals(
                $i,
                $document->getId()
            );
        }

        // Whole collection at once
        $docs = new DocumentCollection();
        for ($i=10; $i<20; $i++) {
            $doc = new Document();
            $doc->setId($i);

            $docs->addDocument($doc);
        }
        $this->setDocumentCollection($docs);

        $this->assertEquals($docs, $this->getDocumentCollection());
    }
    
    public function testGetIterator()
    {
        $iterator = $this->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testGetArrayCopy()
    {
        $realname = 'Test Name';
        
        $user = new \Opg\Core\Model\Entity\User\User();
        $user->setRealname($realname);
        
        $externalId = 123;
        $status = 'Perfect';
        
        $this->setAssignedUser($user);
        $this->setExternalId($externalId);
        $this->setStatus($status);
        
        $array = $this->getArrayCopy();

        $this->assertEquals(
            $externalId,
            $array['externalId']
        );
        
        $this->assertEquals(
            $status,
            $array['status']
        );
        
        $this->assertEquals(
            $realname,
            $array['assignedUser']->getRealname()
        );
    }
}
