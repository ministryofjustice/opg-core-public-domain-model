<?php
/**
 * Created by PhpStorm.
 * User: brettm
 * Date: 02/12/14
 * Time: 14:59
 */

namespace OpgTest\Common\Model\Entity\CaseActor;


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
}
