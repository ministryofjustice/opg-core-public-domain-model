<?php
/**
 * Created by PhpStorm.
 * User: brettm
 * Date: 10/04/14
 * Time: 11:05
 */

namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;

class SystemStatusStub implements HasSystemStatusInterface
{
    use HasSystemStatus;
}

class HasSystemStatusTest extends \PHPUnit_Framework_TestCase
{
    protected $status;

    public function setUp()
    {
        $this->status = new SystemStatusStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->status instanceof SystemStatusStub);
    }

    public function testGetSetStatus()
    {
        $this->assertFalse($this->status->isActive());

        $this->status->setStatus(true);
        $this->assertTrue($this->status->isActive());
    }
}
