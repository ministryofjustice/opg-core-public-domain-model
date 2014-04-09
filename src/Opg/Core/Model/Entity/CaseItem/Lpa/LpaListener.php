<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Application\Specification\Lpa\StatutoryWaitingPeriodSpecification;
use Application\Specification\SpecificationException;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class LpaListener
 * @package Opg\Core\Model\Entity\CaseItem\Lpa
 * @codeCoverageIgnore
 * This test cannot be run at the domain model level as it requires the entity manager
 */
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
    public function preUpdate(Lpa $lpa, PreUpdateEventArgs $eventArgs)
    {
       if($eventArgs->hasChangedField('status') && $eventArgs->getNewValue('status') == 'Registered') {
           if(!$this->statutoryWaitingPeriodSpecification->isSatisfiedBy($lpa)) {
               throw new SpecificationException($this->statutoryWaitingPeriodSpecification->getErrorMessage(), 400, 'status');
           }
       }
    }
}
