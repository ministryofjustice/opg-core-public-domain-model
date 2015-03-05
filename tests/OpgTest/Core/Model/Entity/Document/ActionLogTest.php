<?php

namespace OpgTest\Core\Model\Entity\Document;

use Opg\Core\Model\Entity\Document\ActionLog;

class ActionLogTest extends \PHPUnit_Framework_TestCase {

    /** @var  ActionLog */
    protected $actionLog;

    public function setUp()
    {
        $this->actionLog = new ActionLog();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->actionLog instanceof ActionLog);
    }
}
