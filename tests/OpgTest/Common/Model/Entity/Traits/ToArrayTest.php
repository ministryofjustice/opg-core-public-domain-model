<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * ToArray test case.
 */
class ToArrayTest extends \PHPUnit_Framework_TestCase
{

    use ToArray;

    public function testToArrayTrait()
    {
        $this->assertEquals(
            array(
                'backupGlobals'                   => false,
                'backupGlobalsBlacklist'          => array(),
                'backupStaticAttributes'          => null,
                'backupStaticAttributesBlacklist' => array(),
                'runTestInSeparateProcess'        => false,
                'preserveGlobalState'             => true
            ),
            $this->toArray()
        );
    }
}
