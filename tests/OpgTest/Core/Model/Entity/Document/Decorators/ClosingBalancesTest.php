<?php

namespace OpgTest\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\LineItem\LineItem;
use Opg\Core\Model\Entity\Document\Decorators\ClosingBalances;
use Opg\Core\Model\Entity\Document\Decorators\HasClosingBalances;

class ClosingBalancesStub implements HasClosingBalances
{
    use ClosingBalances;

    public function __unset($value) {
        if (property_exists(get_class($this), $value)) {
            $this->{$value} = null;
        }
    }
}
class ClosingBalancesTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ClosingBalancesStub */
    protected $closingBalances;

    public function setUp()
    {
        $this->closingBalances = new ClosingBalancesStub();
    }

    public function testSetUp()
    {
        unset($this->{'balances'});
        $this->assertTrue($this->closingBalances instanceof HasClosingBalances);
        $this->assertEmpty($this->closingBalances->getClosingBalances()->toArray());
    }

    public function testClosingBalancesCollection()
    {
        $collection = new ArrayCollection();
        $collection->add((new LineItem())->setId(1));
        $collection->add((new LineItem())->setId(2));
        $collection->add((new LineItem())->setId(3));

        $this->assertTrue($this->closingBalances->setClosingBalances($collection) instanceof HasClosingBalances);

        $this->assertTrue($this->closingBalances->closingBalanceExists($collection->first()));

        $this->assertTrue($this->closingBalances->removeClosingBalance($collection->first()) instanceof HasClosingBalances);

        $this->assertFalse($this->closingBalances->closingBalanceExists($collection->first()));

    }
}
