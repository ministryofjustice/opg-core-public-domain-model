<?php

namespace OpgTest\Core\Model\Entity\CaseActor;


use JMS\Serializer\Serializer;
use Opg\Core\Model\Entity\CaseActor\Attorney;
use Opg\Core\Model\Entity\CaseActor\CertificateProvider;
use Opg\Core\Model\Entity\CaseActor\Client;
use Opg\Core\Model\Entity\CaseActor\Correspondent;
use Opg\Core\Model\Entity\CaseActor\Deputy;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseActor\FeePayer;
use Opg\Core\Model\Entity\CaseActor\NonCaseContact;
use Opg\Core\Model\Entity\CaseActor\NotifiedAttorney;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;
use Opg\Core\Model\Entity\CaseActor\NotifiedRelative;
use Opg\Core\Model\Entity\CaseActor\PersonFactory;
use Opg\Core\Model\Entity\CaseActor\PersonNotifyDonor;
use Opg\Core\Model\Entity\CaseActor\ReplacementAttorney;
use Opg\Core\Model\Entity\CaseActor\TrustCorporation;

class PersonFactoryTest extends \PHPUnit_Framework_TestCase
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
        $data = array('personType' => '', 'id' => 1);
        PersonFactory::create($data, $this->serializer);
    }

    /**
     * @expectedException \Exception
     */
    public function testUnknownIdReturnsNull()
    {
        $data = array('personType' => 'Donor', 'id' => -1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andThrow(new \Exception());

        PersonFactory::create($data, $this->serializer);
    }

    public function testUnknownTypeReturnsNonCaseContact()
    {
        $data = array('personType' => 'Doctor', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new NonCaseContact())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof NonCaseContact);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testNoPersonTypeReturnsDonor()
    {
        $data = array('id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Donor())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof Donor);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testAttorney()
    {
        $data = array('personType' => 'Attorney', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Attorney())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof Attorney);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testReplacementAttorney()
    {
        $data = array('personType' => 'ReplacementAttorney', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new ReplacementAttorney())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof ReplacementAttorney);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testTrustCorporation()
    {
        $data = array('personType' => 'TrustCorporation', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new TrustCorporation())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof TrustCorporation);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testCertificateProvider()
    {
        $data = array('personType' => 'CertificateProvider', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new CertificateProvider())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof CertificateProvider);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testNotifiedPerson()
    {
        $data = array('personType' => 'NotifiedPerson', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new NotifiedPerson())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof NotifiedPerson);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testCorrespondent()
    {
        $data = array('personType' => 'Correspondent', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Correspondent())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof Correspondent);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testNotifiedRelative()
    {
        $data = array('personType' => 'NotifiedRelative', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new NotifiedRelative())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof NotifiedRelative);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testNotifiedAttorney()
    {
        $data = array('personType' => 'NotifiedAttorney', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new NotifiedAttorney())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof NotifiedAttorney);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testPersonNotifyDonor()
    {
        $data = array('personType' => 'PersonNotifyDonor', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new PersonNotifyDonor())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof PersonNotifyDonor);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testClient()
    {
        $data = array('personType' => 'Client', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Client())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof Client);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testClientNoId()
    {
        $data = array('personType' => 'Client');

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Client()));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof Client);
        $this->assertEmpty($person->getId());
    }

    public function testDeputy()
    {
        $data = array('personType' => 'Deputy', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new Deputy())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof Deputy);
        $this->assertEquals($data['id'], $person->getId());
    }

    public function testFeePayer()
    {
        $data = array('personType' => 'FeePayer', 'id' => 1);

        $this->serializer
            ->shouldReceive('deserialize')
            ->withAnyArgs()
            ->andReturn((new FeePayer())->setId($data['id']));

        $person = PersonFactory::create($data, $this->serializer);

        $this->assertTrue($person instanceof FeePayer);
        $this->assertEquals($data['id'], $person->getId());
    }

}
