<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship;

use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Order;
use Opg\Core\Model\Entity\CaseActor\Donor;

class OrderTest extends \PHPUnit_Framework_TestCase
{

    protected $layDeputy;

    public function setUp()
    {
        $this->layDeputy = new Order();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->layDeputy instanceof Order);
    }

    public function testSetId()
    {
        $expectedID = '1234560';
        $this->layDeputy->setId($expectedID);
        $this->assertEquals($expectedID, $this->layDeputy->getId());
    }

    public function testGetSetInputFilter()
    {
        $mockInputFilter = $this->getMockForAbstractClass('Zend\InputFilter\InputFilterInterface');

        try {
            $this->layDeputy->setInputFilter($mockInputFilter);
        } catch (\Exception $e) {
            var_dump($e->getMessage(), get_class($e));
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }

        try {
            $this->layDeputy->getInputFilter();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

    public function testAddPerson()
    {
        try {
            $this->layDeputy->addPerson(new Donor());
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

}
