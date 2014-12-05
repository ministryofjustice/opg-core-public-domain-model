<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasFees;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasFeesInterface;
use Opg\Core\Model\Entity\Fee\DeputyshipFees;

class HasFeesStub implements HasFeesInterface
{
    use HasFees;

    public function __unset($key)
    {
        if (property_exists(get_class($this), $key)) {
            $this->{$key} = null;
        }
    }
}

class HasFeesTest extends \PHPUnit_Framework_TestCase
{
    /** @var  HasFeesStub */
    protected $hasFees;

    public function setUp()
    {
        $this->hasFees = new HasFeesStub();
    }

    public function testSetUp()
    {
        unset($this->hasFees->{'fees'});
        $this->assertTrue($this->hasFees instanceof HasFeesInterface);

        $this->assertEmpty($this->hasFees->getFees()->toArray());
    }

    public function testGetSetFees()
    {
        $this->assertEmpty($this->hasFees->getFees()->count());

        $fees = new ArrayCollection();

        for ($i=1; $i<=10; $i++) {
            $fees->add((new DeputyshipFees())->setId($i));
        }

        $this->assertTrue($this->hasFees->setFees($fees) instanceof HasFeesInterface);

        $this->assertCount(10, $this->hasFees->getFees()->toArray());
    }

    public function testGetSetHasFee()
    {
        $expected = (new DeputyshipFees())->setId(1);

        $this->assertFalse($this->hasFees->hasFee($expected));
        $this->assertTrue($this->hasFees->addFee($expected) instanceof HasFeesInterface);
        $this->assertTrue($this->hasFees->hasFee($expected));

    }

    public function testGetSetRemoveFee()
    {
        $expected = (new DeputyshipFees())->setId(1);

        $this->assertFalse($this->hasFees->hasFee($expected));
        $this->assertTrue($this->hasFees->addFee($expected) instanceof HasFeesInterface);
        $this->assertTrue($this->hasFees->hasFee($expected));
        $this->assertTrue($this->hasFees->removeFee($expected) instanceof HasFeesInterface);
        $this->assertFalse($this->hasFees->hasFee($expected));


    }
}
