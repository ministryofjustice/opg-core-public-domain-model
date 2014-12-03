<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasAnnualReports;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasAnnualReportsInterface;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Report\AnnualReport;

class AnnualReportsStub implements HasAnnualReportsInterface
{
    use HasAnnualReports;

    public function __unset($value)
    {
        if (property_exists(get_class($this), $value)) {
            $this->{$value} = null;
        }
    }
}

class HasAnnualReportsTest extends \PHPUnit_Framework_TestCase {

    /** @var  AnnualReportsStub */
    protected $stub;

    public function setUp()
    {
        $this->stub = new AnnualReportsStub();
    }

    public function testSetUp()
    {
        unset($this->{'annualReports'});
        $this->assertTrue($this->stub instanceof HasAnnualReportsInterface);
        $this->assertEmpty($this->stub->getAnnualReports()->toArray());
    }

    public function testSetFunds()
    {
        $collection = new ArrayCollection();

        for ($i=1; $i<=10; $i++) {
            $collection->add( (new AnnualReport())->setId($i));
        }

        $this->stub->setAnnualReports($collection);
        $this->assertEquals($collection, $this->stub->getAnnualReports());
        $this->assertCount(10, $this->stub->getAnnualReports()->toArray());
    }

    public function testAddRemoveDeputies()
    {
        $d1 = (new AnnualReport())->setId(1);
        $d2 = (new AnnualReport())->setId(2);

        $this->stub->addAnnualReport($d1)->addAnnualReport($d2);

        $this->assertTrue($this->stub->hasAnnualReport($d1));
        $this->assertTrue($this->stub->hasAnnualReport($d2));

        $this->stub->removeAnnualReport($d1);

        $this->assertFalse($this->stub->hasAnnualReport($d1));
        $this->assertTrue($this->stub->hasAnnualReport($d2));

    }
}
