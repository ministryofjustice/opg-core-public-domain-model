<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class DeputyFilter
 * @package Opg\Core\Model\Entity\CaseActor\Validation\InputFilter
 */
class DeputyFilter extends BaseInputFilter
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
        $this->addValidator('deputyCompliance', 'Opg\Core\Model\Entity\CaseActor\Validation\Validator\DeputyCompliance');
    }
}
