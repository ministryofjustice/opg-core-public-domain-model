<?php

namespace OpgTest\Core\Model\Entity\Assignable;


use Opg\Core\Model\Entity\Assignable\IsAssignable;

class IsAssignableTest extends \PHPUnit_Framework_TestCase {

    protected $interface;

    public function setUp()
    {
        $this->interface = $this->getMock('Opg\Core\Model\Entity\Assignable\IsAssignable');
    }

    public function testSetUp()
    {
        $this->assertTrue($this->interface instanceof IsAssignable);
    }

}
