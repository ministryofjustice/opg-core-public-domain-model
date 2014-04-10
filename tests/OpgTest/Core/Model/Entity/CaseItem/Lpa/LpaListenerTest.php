<?php

namespace OpgTest\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\LpaListener;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

/**
 * Class LpaListenerTest
 * @package OpgTest\Core\Model\Entity\CaseItem\Lpa
 * @todo Move this into the backend
 */
class LpaListenerTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->preUpdateEventArgs = \Mockery::mock('Doctrine\ORM\Event\PreUpdateEventArgs');
        $this->preUpdateEventArgs->shouldReceive('hasChangedField')->andReturn(true)->mock();
        $this->preUpdateEventArgs->shouldReceive('getNewValue')->with('status')->andReturn(true)->mock();

        $this->lpa = new Lpa();

        $this->testStatutoryWaitingPeriodSpecification = \Mockery::mock('Application\Specification\Lpa\StatutoryWaitingPeriodSpecification');
        $this->testStatutoryWaitingPeriodSpecification->shouldReceive('isSatisfiedBy')->with($this->lpa)->andReturn(false)->mock();

    }

    /**
     * expectedException     \Application\Specification\SpecificationException
     * expectedExceptionCode 400
     */
    public function testLpaListenerTestThrowsException()
    {
        $this->markTestIncomplete('need to sort out dependancies');
        $lpaListener = new LpaListener($this->testStatutoryWaitingPeriodSpecification);
        $lpaListener->preUpdate($this->lpa, $this->preUpdateEventArgs);

    }
}
