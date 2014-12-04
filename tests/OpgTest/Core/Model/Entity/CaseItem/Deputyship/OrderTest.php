<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Filter\BaseInputFilter;
use Opg\Core\Model\Entity\CaseActor\Attorney;
use Opg\Core\Model\Entity\CaseActor\Client;
use Opg\Core\Model\Entity\CaseActor\Deputy;
use Opg\Core\Model\Entity\CaseActor\FeePayer;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Order;
use Opg\Core\Model\Entity\CaseActor\Donor;

class OrderTest extends \PHPUnit_Framework_TestCase
{

    /** @var  Order */
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
            $this->assertTrue($e instanceof UnusedException);
        }

        $if = $this->layDeputy->getInputFilter();
        $this->assertTrue($if instanceof BaseInputFilter);
    }

    public function testAddPerson()
    {
        try {
            $this->layDeputy->addPerson(new NotifiedPerson());
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
        }

        try {
            $this->layDeputy->addPerson(new Donor());
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
        }

        try {
            $this->layDeputy->addPerson(new Attorney());
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
        }

        $this->assertTrue($this->layDeputy->addPerson(new Client()) instanceof CaseItem);
        $this->assertTrue($this->layDeputy->addPerson(new Deputy()) instanceof CaseItem);
        $this->assertTrue($this->layDeputy->addPerson(new FeePayer()) instanceof CaseItem);

        $this->assertTrue($this->layDeputy->getClient() instanceof Client);
        $this->assertTrue($this->layDeputy->getDeputies() instanceof ArrayCollection);
        $this->assertTrue($this->layDeputy->getFeePayer() instanceof FeePayer);
    }

    public function testGetSetOrderStatus()
    {
        $expected = 'True';

        $this->assertEmpty($this->layDeputy->getOrderStatus());
        $this->assertTrue($this->layDeputy->setOrderStatus($expected) instanceof Order);
        $this->assertEquals($expected, $this->layDeputy->getOrderStatus());
        $this->assertFalse($this->layDeputy->isValid(array('orderStatus')));

        $expected = 'Active';

        $this->assertTrue($this->layDeputy->setOrderStatus($expected) instanceof Order);
        $this->assertEquals($expected, $this->layDeputy->getOrderStatus());
        $this->assertTrue($this->layDeputy->isValid(array('orderStatus')));
    }
}
