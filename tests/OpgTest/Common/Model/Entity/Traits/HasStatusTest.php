<?php
/**
 * Created by PhpStorm.
 * User: brettm
 * Date: 03/12/14
 * Time: 16:28
 */

namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\HasStatusDate;
use Opg\Common\Model\Entity\Traits\StatusDate;

class HasStatusStub implements HasStatusDate
{
    use StatusDate;
}


class HasStatusTest extends \PHPUnit_Framework_TestCase
{
    /** @var  HasStatusStub */
    protected $stub;

    public function setUp()
    {
        $this->stub = new HasStatusStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->stub instanceof HasStatusDate);
    }

    public function testGetSetDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->stub->getStatusDate());
        $this->assertTrue($this->stub->setStatusDate($expected) instanceof HasStatusDate);
        $this->assertEquals($expected, $this->stub->getStatusDate());
    }
}
