<?php

namespace OpgTest\Core\Model\Entity\Assignable;

use Opg\Core\Model\Entity\Assignable\Assignee;
use Opg\Core\Model\Entity\Assignable\IsAssignable;
use Opg\Core\Model\Entity\User\User;

class AssigneeStub implements IsAssignable
{
    use Assignee;
}

class AssigneeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AssigneeStub
     */
    protected $assignee;

    public function setUp()
    {
        $this->assignee = new AssigneeStub();
    }

    public function testSetup()
    {
        $user = new User();

        $this->assertFalse($this->assignee->isAssigned());
        $this->assertTrue($this->assignee->assign($user) instanceof AssigneeStub);
        $this->assertTrue($this->assignee->isAssigned());
        $this->assertEquals($user, $this->assignee->getAssignee());
    }


}
