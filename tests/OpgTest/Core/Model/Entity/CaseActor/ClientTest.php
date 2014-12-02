<?php

namespace OpgTest\Common\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Client */
    protected $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->client instanceof Client);
    }

    public function testGetSetCaseRecNumber()
    {
        $expected = '1234567A';

        $this->assertEmpty($this->client->getCaseRecNumber());
        $this->assertTrue($this->client->setCaseRecNumber($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getCaseRecNumber());
    }

    public function testGetSetClientAccommodation()
    {
        $expected = 'No accommodation';

        $this->assertEmpty($this->client->getClientAccommodation());
        $this->assertTrue($this->client->setClientAccommodation($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getClientAccommodation());

        $this->assertFalse($this->client->isValid(array('clientAccommodation')));

        $expected = 'No Accommodation Type';
        $this->assertTrue($this->client->setClientAccommodation($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getClientAccommodation());
        $this->assertTrue($this->client->isValid(array('clientAccommodation')));
    }

    public function testGetSetClientStatus()
    {
        $expected = 'yes';

        $this->assertEmpty($this->client->getClientStatus());
        $this->assertTrue($this->client->setClientStatus($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getClientStatus());

        $this->assertFalse($this->client->isValid(array('clientStatus')));

        $expected = 'Active';
        $this->assertTrue($this->client->setClientStatus($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getClientStatus());
        $this->assertTrue($this->client->isValid(array('clientStatus')));
    }

    public function testGetSetMaritalStatus()
    {
        $expected = 'moo';

        $this->assertEmpty($this->client->getMaritalStatus());
        $this->assertTrue($this->client->setMaritalStatus($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getMaritalStatus());
        $this->assertFalse($this->client->isValid(array('maritalStatus')));

        $expected = 'Not Stated';
        $this->assertTrue($this->client->setMaritalStatus($expected) instanceof Client);
        $this->assertEquals($expected, $this->client->getMaritalStatus());
        $this->assertTrue($this->client->isValid(array('maritalStatus')));
    }
}
