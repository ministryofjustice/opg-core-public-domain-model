<?php

namespace OpgTest\Common\Model\Entity\CaseActor;


use Opg\Core\Model\Entity\Assignable\NullEntity;
use Opg\Core\Model\Entity\Assignable\User;
use Opg\Core\Model\Entity\CaseActor\Deputy;

class DeputyTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Deputy */
    protected $actor;

    public function setUp()
    {
        $this->actor = new Deputy();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->actor instanceof Deputy);
        $this->assertEmpty($this->actor->getDeputyCompliance());
        $this->assertEmpty($this->actor->getDeputyReferenceNumber());
    }

    public function testGetSetDeputyCompliance()
    {
        $expected = 'yes';
        $this->assertEmpty($this->actor->getDeputyCompliance());
        $this->assertTrue($this->actor->setDeputyCompliance($expected) instanceof Deputy);
        $this->assertEquals($expected, $this->actor->getDeputyCompliance());
        $this->assertFalse($this->actor->isValid(array('deputyCompliance')));

        $expected = 'Compliant';
        $this->assertTrue($this->actor->setDeputyCompliance($expected) instanceof Deputy);
        $this->assertEquals($expected, $this->actor->getDeputyCompliance());
        $this->assertTrue($this->actor->isValid(array('deputyCompliance')));

    }

    public function testGetSetDeputyReferenceNumber()
    {
        $expected = '123ABC456';
        $this->assertEmpty($this->actor->getDeputyReferenceNumber());
        $this->assertTrue($this->actor->setDeputyReferenceNumber($expected) instanceof Deputy);
        $this->assertEquals($expected, $this->actor->getDeputyReferenceNumber());
    }

    public function testDeputyCanBeAssigned()
    {
        $assignee = (new User())->setId(1);

        $this->assertFalse($this->actor->isAssigned());
        $this->assertTrue($this->actor->getAssignee() instanceof NullEntity);
        $this->assertTrue($this->actor->assign($assignee) instanceof Deputy);

        $this->assertTrue($this->actor->isAssigned());
        $this->assertEquals($assignee, $this->actor->getAssignee());
    }

    public function testGetSetRelationshipToClient()
    {
        $this->actor->setRelationshipToClient('daughter');

        $this->assertEquals('daughter', $this->actor->getRelationshipToClient());
    }
}
