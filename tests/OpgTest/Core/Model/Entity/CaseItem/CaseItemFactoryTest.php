<?php

namespace OpgTest\Core\Model\Entity\CaseItem;


use Opg\Core\Model\Entity\CaseItem\CaseItemFactory;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Order;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Epa;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa;

class CaseItemFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Mockery\MockInterface */
    protected $serializer;

    public function setUp()
    {
        $this->serializer = \Mockery::mock("JMS\Serializer\Serializer");
    }

    /**
     * @expectedException \Exception
     */
    public function testEmptyTypeThrowsException()
    {
        $data = array('caseType' => '', 'id' => 1);
        CaseItemFactory::create($data, $this->serializer);
    }

    /**
     * @expectedException \Exception
     */
    public function testUnknownIdReturnsNull()
    {
        $data = array('caseType' => 'Lpa', 'id' => -1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andThrow(new \Exception());

        $case = CaseItemFactory::create($data, $this->serializer);

        $this->assertNull($case);
    }

    public function testUnknownTypeReturnsLpa()
    {
        $data = array('caseType' => 'Suitcase', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Lpa())->setId($data['id']));

        $case = CaseItemFactory::create($data, $this->serializer);

        $this->assertTrue($case instanceof Lpa);
        $this->assertEquals($data['id'], $case->getId());
    }

    public function testNoCaseTypeReturnsLpa()
    {
        $data = array('id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Lpa())->setId($data['id']));

        $case = CaseItemFactory::create($data, $this->serializer);

        $this->assertTrue($case instanceof Lpa);
        $this->assertEquals($data['id'], $case->getId());
    }

    public function testCreateEpa()
    {
        $data = array('caseType' => 'Epa', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Epa())->setId($data['id']));

        $case = CaseItemFactory::create($data, $this->serializer);

        $this->assertTrue($case instanceof Epa);
        $this->assertEquals($data['id'], $case->getId());
    }

    public function testCreateOrder()
    {
        $data = array('caseType' => 'Order', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Order())->setId($data['id']));

        $case = CaseItemFactory::create($data, $this->serializer);

        $this->assertTrue($case instanceof Order);
        $this->assertEquals($data['id'], $case->getId());
    }

}
