<?php

namespace OpgTest\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\LpaListener;
use Opg\Core\Model\Entity\CaseItem\Lpa;
use Application\Specification\SpecificationException;


class LpaListenerTest extends \PHPUnit_Framework_TestCase
{

    public function __setup()
    {
        $this->preUpdateEventArgs = \Mockery::mock('PreUpdateEventArgs');
        $this->preUpdateEventArgs->shouldReceive('hasChangedField')->andReturn(true)->mock();
        $this->preUpdateEventArgs->shouldReceive('getNewValue')->with('status')->andReturn(true)->mock();

        $this->testStatutoryWaitingPeriodSpecification = \Mockery::mock('StatutoryWaitingPeriodSpecification');
        $this->testStatutoryWaitingPeriodSpecification->shouldReceive('isSatisfiedBy')->andReturn('false');
    }

    /**
     * expectedException     SpecificationException
     * expectedExceptionCode 400
     */
    public function testLpaListenerTestThrowsException()
    {
        $this->markTestIncomplete('will fix');
        $lpaListener = new LpaListener($this->testStatutoryWaitingPeriodSpecification);
        $lpa = new Lpa();
        $lpaListener->preUpdate($lpa, $this->preUpdateEventArgs);

    }
}