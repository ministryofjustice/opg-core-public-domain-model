<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseActor\Decorators\CaseRecNumber;
use Opg\Core\Model\Entity\CaseActor\Decorators\ClientAccommodation;
use Opg\Core\Model\Entity\CaseActor\Decorators\ClientStatus;
use Opg\Core\Model\Entity\CaseActor\Decorators\MaritalStatus;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasCaseRecNumber;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasClientAccommodation;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasClientStatus;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasMaritalStatus;
use Opg\Core\Model\Entity\CaseActor\Validation\InputFilter\ClientFilter;

/**
 * Class Client
 * @package Opg\Core\Model\Entity\CaseActor
 *
 * @ORM\Entity
 */
class Client extends Donor implements HasCaseRecNumber, HasClientAccommodation, HasMaritalStatus, HasClientStatus
{
    use CaseRecNumber;
    use ClientAccommodation;
    use MaritalStatus;
    use ClientStatus;

    /**
     * @return \Opg\Common\Model\Entity\Traits\InputFilter|\Zend\InputFilter\InputFilter|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = parent::getInputFilter();
            $this->inputFilter->merge(new ClientFilter());
        }

        return $this->inputFilter;
    }
}
