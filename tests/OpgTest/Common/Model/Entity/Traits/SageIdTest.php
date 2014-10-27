<?php

namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\HasSageId;
use Opg\Common\Model\Entity\LuhnCheckDigit;
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

   public function testForCollision()
   {
        $iterations = 10000;
        $this->ids = $this->expectedIds = array();

        for ($i = 1; $i<= $iterations; ++$i) {
            $uid =  sprintf('7%010d', $i);
            $this->ids[]  = sprintf('%d%d', $uid, LuhnCheckDigit::createCheckSum($uid));
            $this->expectedIds[] = sprintf('L%07s', strtoupper(base_convert($i, 10, 36)));
        }

       $this->assertEquals($iterations, count(array_unique($this->expectedIds)));
       $this->assertEquals($iterations, count(array_unique($this->ids)));
       $this->assertEquals(count(array_unique($this->ids)), count(array_unique($this->expectedIds)));

       foreach ($this->ids as $key=>$id) {
           $this->stub->uId = $id;
           $this->stub->unsetId();

           $this->assertEquals($this->expectedIds[$key], $this->stub->getSageId());

           $this->assertEquals(substr($id,1,10), base_convert(substr($this->stub->getSageId(),1), 36, 10));
       }
   }
}
