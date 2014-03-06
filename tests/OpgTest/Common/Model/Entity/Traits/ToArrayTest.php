<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * ToArray test case.
 */
class ToArrayTest extends \PHPUnit_Framework_TestCase
{

    use ToArray;

    protected $arrayOfArrayCollections;

    protected $entityInterface;


    public function setUp()
    {
        $this->entityInterface = new \Opg\Core\Model\Entity\Address\Address();
        $arrayData             = array();

        for ($i = 0; $i < 3; $i++) {
            array_push($arrayData, new ArrayCollection(array($i)));
        }

        $this->arrayOfArrayCollections = $arrayData;
    }

    public function testToArrayTrait()
    {
        $this->assertEquals(
            array(
                'arrayOfArrayCollections'         =>
                    array(
                        array(0),
                        array(1),
                        array(2)
                    ),
                'entityInterface'                 => array(
                    'id'            => null,
                    'addressLines'  => [],
                    'town'          => null,
                    'county'        => null,
                    'postcode'      => null,
                    'country'       => null,
                    'errorMessages' => [],
                    'person' => null,
                    'type' => 'Primary'
                ),
                'backupGlobals'                   => false,
                'backupGlobalsBlacklist'          => array(),
                'backupStaticAttributes'          => null,
                'backupStaticAttributesBlacklist' => array(),
                'runTestInSeparateProcess'        => false,
                'preserveGlobalState'             => true,
                'className'                       => 'OpgTest\Common\Model\Entity\Traits\ToArrayTest'
            ),
            $this->toArray(true)
        );
    }

    public function testToArrayRecursive()
    {
        $expected = array(
            'id' => 123,
            'foo' => 'bar',
            'subArray' => array(
                '1' => 'chicken',
                '2' => 'chips'
            )
        );

        $expectedObject = new \ArrayObject($expected);

        $parsedObject = $this->toArrayRecursive(false, $expectedObject);

        $this->assertEquals($expected, $parsedObject);

        $parsedObject2 = $this->toArrayRecursive(true, $expectedObject);


        $this->assertEquals(__CLASS__, $parsedObject2['className']);
    }
}
