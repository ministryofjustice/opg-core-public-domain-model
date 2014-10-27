<?php

namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\HasSageId;
use Opg\Common\Model\Entity\Traits\SageId;

class SageIdStub implements HasSageId {

    public $uId;

    use SageId;

    public function unsetId()
    {
        $this->sageId = null;
    }
}

class SageIdTest extends \PHPUnit_Framework_TestCase {

    protected $ids = array(
        '700000000021',
        '700000000666',
        '700000001045'
    );

    protected $expectedIds = array(
        'L0000002',
        'L000001U',
        'L000002W'
    );
    /** @var  SageIdStub */
    protected $stub;

    public function setUp()
    {
        $this->stub = new SageIdStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->stub instanceof SageIdStub);
        $this->assertTrue($this->stub instanceof HasSageId);
    }

    /**
     * @expectedException \LogicException
     */
    public function testInvalidUidThrowsException()
    {
        $this->stub->uId = substr($this->expectedIds[0],0, 11) . '4';
        $this->stub->unsetId();
        $this->stub->getSageId();
    }


    public function testConversion()
    {
        foreach ($this->ids as $key=>$id) {
            $this->stub->uId = $id;
            $this->stub->unsetId();

            $this->assertEquals($this->expectedIds[$key], $this->stub->getSageId());

            $this->assertEquals(substr($id,1,10), base_convert(substr($this->stub->getSageId(),1), 36, 10));
        }
    }
}
