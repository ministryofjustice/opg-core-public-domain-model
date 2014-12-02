<?php

namespace OpgTest\Core\Model\Entity\CaseActor;


use Opg\Core\Model\Entity\CaseActor\Interfaces\HasRelationshipToDonor;

class HasRelationshipToDonorTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $expectedMethods = array('getRelationshipToDonor', 'setRelationshipToDonor');
        $interfaceMock = $this->getMock('Opg\Core\Model\Entity\CaseActor\Interfaces\HasRelationshipToDonor');

        $this->assertTrue($interfaceMock instanceof HasRelationshipToDonor);

        $classMethods = get_class_methods($interfaceMock);

        foreach($expectedMethods as $method) {
            $this->assertTrue(in_array($method, $classMethods));
        }
    }
}
