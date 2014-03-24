<?php
/**
 * Created by PhpStorm.
 * User: brettm
 * Date: 24/03/14
 * Time: 12:22
 */

namespace OpgTest\Core\Model\Entity\CaseItem\Lpa\Party;


class HasRelationshipToDonorTest extends \PHPUnit_Framework_TestCase
{
    public function testInterface()
    {
        $expectedMethods = array('getRelationshipToDonor', 'setRelationshipToDonor');
        $interfaceMock = $this->getMock('Opg\Core\Model\Entity\CaseItem\Lpa\Party\HasRelationshipToDonor');

        $this->assertTrue($interfaceMock instanceof \Opg\Core\Model\Entity\CaseItem\Lpa\Party\HasRelationshipToDonor);

        $classMethods = get_class_methods($interfaceMock);

        foreach($expectedMethods as $method) {
            $this->assertTrue(in_array($method, $classMethods));
        }
    }
}
