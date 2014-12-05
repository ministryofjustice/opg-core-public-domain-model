<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasCourtFunds;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasCourtFundsInterface;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Funds\CourtFund;

class CourtFundsStub implements HasCourtFundsInterface
{
    use HasCourtFunds;

    public function __unset($value)
    {
        if (property_exists(get_class($this), $value)) {
            $this->{$value} = null;
        }
    }
}

class HasCourtFundsTest extends \PHPUnit_Framework_TestCase {

    /** @var  CourtFundsStub */
    protected $stub;

    public function setUp()
    {
        $this->stub = new CourtFundsStub();
    }

    public function testSetUp()
    {
        unset($this->{'courtFunds'});
        $this->assertTrue($this->stub instanceof HasCourtFundsInterface);
        $this->assertEmpty($this->stub->getCourtFunds()->toArray());
    }

    public function testSetFunds()
    {
        $collection = new ArrayCollection();

        for ($i=1; $i<=10; $i++) {
            $collection->add( (new CourtFund())->setId($i));
        }

        $this->stub->setCourtFunds($collection);
        $this->assertEquals($collection, $this->stub->getCourtFunds());
        $this->assertCount(10, $this->stub->getCourtFunds()->toArray());
    }

    public function testAddRemoveDeputies()
    {
        $d1 = (new CourtFund())->setId(1);
        $d2 = (new CourtFund())->setId(2);

        $this->stub->addCourtFund($d1)->addCourtFund($d2);

        $this->assertTrue($this->stub->hasCourtFund($d1));
        $this->assertTrue($this->stub->hasCourtFund($d2));

        $this->stub->removeCourtFund($d1);

        $this->assertFalse($this->stub->hasCourtFund($d1));
        $this->assertTrue($this->stub->hasCourtFund($d2));

    }
}
