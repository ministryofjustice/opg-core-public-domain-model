<?php
namespace OpgTest\Core\Model\Entity\CaseItem;

use Opg\Core\Model\Entity\CaseItem\BusinessRule;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;


/**
 * ToArray test case.
 */
class BusinessRuleTest extends \PHPUnit_Framework_TestCase
{

    protected function getMockedClass()
    {
        return $this->getMockForAbstractClass('\Opg\Core\Model\Entity\CaseItem\BusinessRule');
    }

    public function testSetGetId()
    {
        $businessRuleMock = $this->getMockedClass();
        $expected     = 123;
        $businessRuleMock->setId($expected);

        $this->assertEquals($expected, $businessRuleMock->getId());
    }

    public function testSetGetKey()
    {
        $businessRuleMock = $this->getMockedClass();
        $expected     = 'testkey';
        $businessRuleMock->setKey($expected);

        $this->assertEquals($expected, $businessRuleMock->getKey());
    }

    public function testSetGetValue()
    {
        $businessRuleMock = $this->getMockedClass();
        $expected     = 'testvalue';
        $businessRuleMock->setValue($expected);

        $this->assertEquals($expected, $businessRuleMock->getValue());
    }

    public function testSetGetCase()
    {
        $businessRuleMock = $this->getMockedClass();
        $expected     = new Lpa();
        $businessRuleMock->setCase($expected);

        $this->assertEquals($expected, $businessRuleMock->getCase());
    }

    public function testSetGetDatetimeDefault()
    {
        $businessRule = new BusinessRule();

        $this->assertInstanceOf('Datetime', $businessRule->getCreatedOn());
    }

    public function testSetGetDatetime()
    {
        $now = new \Datetime;
        $businessRuleMock = $this->getMockedClass();

        $businessRuleMock->setCreatedOn($now);

        $this->assertEquals($now, $businessRuleMock->getCreatedOn());
    }
}
