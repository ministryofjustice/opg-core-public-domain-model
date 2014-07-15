<?php

namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;

class UIDStub implements HasUidInterface
{
    use UniqueIdentifier;
}

class UniqueIdentifierTest extends \PHPUnit_Framework_TestCase
{

    protected $uid;

    public function setUp()
    {
        $this->uid = new UIDStub();
    }


    public function testGetSetUid()
    {
        $expected = '700012345678';

        $this->assertEmpty($this->uid->getUid());

        $this->assertEquals($expected, $this->uid->setUid($expected)->getUid());
    }

    public function testGetSetFormattedUid()
    {
        $expected = '700012345678';

        $formatRegex = '/^(\d{4})-(\d{4})-(\d{4})$/';

        $this->assertEmpty($this->uid->getUid());

        $this->assertEquals($expected, $this->uid->setUid($expected)->getUid());

        $this->assertNotEmpty(preg_match($formatRegex, $this->uid->getUidString()));

        $expectedString = $this->uid->getUidString();

        $this->assertEquals($expected, $this->uid->setUidString($expectedString)->getUid());
    }
}
