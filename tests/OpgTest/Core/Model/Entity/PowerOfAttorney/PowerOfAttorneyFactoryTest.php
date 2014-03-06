<?php

namespace OpgTest\Core\Model\Entity\PowerOfAttorney;

use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorneyFactory;

class PowerOfAttorneyFactoryTest extends \PHPUnit_Framework_TestCase {

    public function testCreateFailNoClassName()
    {
        try {
            PowerOfAttorneyFactory::createPowerOfAttorney(array());
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Exception);
            $this->assertFalse($e instanceof UnusedException);
            $this->assertEquals('Cannot build Power of Attorney of unknown type', $e->getMessage());
        }
    }

    public function testCreateFailUnknownType()
    {
        try {
            PowerOfAttorneyFactory::createPowerOfAttorney(array('className'=>'Opg\\Core\\Model\\Entity\\CaseItem\\LayDeputy'));
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Exception);
            $this->assertTrue($e instanceof UnusedException);
            $this->assertEquals('Classname not found', $e->getMessage());
        }
    }

    public function testCreatePass()
    {
        $poaObject = PowerOfAttorneyFactory::createPowerOfAttorney(array('className'=>'Opg\\Core\\Model\\Entity\\Lpa\\Lpa'));
        $this->assertTrue($poaObject instanceof Lpa);
    }
}
