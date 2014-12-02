<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class ClientFilter
 * @package Opg\Core\Model\Entity\CaseActor\Validation\InputFilter
 */
class ClientFilter extends BaseInputFilter
{

    /** @var  InputFactory */
    protected $inputFactory;

    public function __construct()
    {
        $this->inputFactory = new InputFactory();

        $this->setvalidators();
    }

    protected function setValidators()
    {
        $this->addValidator('maritalStatus', 'Opg\Core\Model\Entity\CaseActor\Validation\Validator\MaritalStatus');
        $this->addValidator('clientStatus', 'Opg\Core\Model\Entity\CaseActor\Validation\Validator\ClientStatus');
        $this->addValidator('clientAccommodation','Opg\Core\Model\Entity\CaseActor\Validation\Validator\ClientAccommodation');
    }
}
