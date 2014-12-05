<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\Deputy;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasDeputies;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasDeputiesInterface;

class HasDeputiesStub implements HasDeputiesInterface
{
    use HasDeputies;

    public function __unset($value)
    {
        if (property_exists(get_class($this), $value)) {
            $this->{$value} = null;
        }
    }
}

class HasDeputiesTest extends \PHPUnit_Framework_TestCase {

    /** @var  HasDeputiesStub */
    protected $stub;

    public function setUp()
    {
        $this->stub = new HasDeputiesStub();
    }

    public function testSetUp()
    {
        unset($this->{'deputies'});
        $this->assertTrue($this->stub instanceof HasDeputiesInterface);
        $this->assertEmpty($this->stub->getDeputies()->toArray());
    }

    public function testSetDeputies()
    {
        $collection = new ArrayCollection();

        for ($i=1; $i<=10; $i++) {
            $collection->add( (new Deputy())->setId($i));
        }

        $this->stub->setDeputies($collection);
        $this->assertEquals($collection, $this->stub->getDeputies());
        $this->assertCount(10, $this->stub->getDeputies()->toArray());
    }

    public function testAddRemoveDeputies()
    {
        $d1 = (new Deputy())->setId(1);
        $d2 = (new Deputy())->setId(2);

        $this->stub->addDeputy($d1)->addDeputy($d2);

        $this->assertTrue($this->stub->hasDeputy($d1));
        $this->assertTrue($this->stub->hasDeputy($d2));

        $this->stub->removeDeputy($d1);

        $this->assertFalse($this->stub->hasDeputy($d1));
        $this->assertTrue($this->stub->hasDeputy($d2));

    }
}
