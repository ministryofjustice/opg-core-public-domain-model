<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Application\Specification\Lpa\StatutoryWaitingPeriodSpecification;
use Doctrine\ORM\Event\PreUpdateEventArgs;


class LpaListener
{
    /**
     * @param StatutoryWaitingPeriodSpecification $specification
     */
    public function __construct(StatutoryWaitingPeriodSpecification $specification)
    {
        $this->statutoryWaitingPeriodSpecification = $specification;
    }

    /**
     * Fire business rule on pre Update of Case.
     *
     * @param Lpa $lpa
     * @param $eventArgs
     */
    public function preUpdate(Lpa $lpa,PreUpdateEventArgs $eventArgs)
    {
       if($eventArgs->hasChangedField('status') && $eventArgs->getNewValue('status') == 'Registered') {
           if(!$this->statutoryWaitingPeriodSpecification->isSatisfiedBy($lpa)) {
                throw new \Exception($this->statutoryWaitingPeriodSpecification->getErrorMessage());
           }
       }
    }
}
