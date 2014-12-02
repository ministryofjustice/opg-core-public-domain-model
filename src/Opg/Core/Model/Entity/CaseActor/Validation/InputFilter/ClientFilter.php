<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\InputFilter;

use Opg\Core\Model\Entity\CaseActor\Validation\Validator\ClientAccommodation;
use Opg\Core\Model\Entity\CaseActor\Validation\Validator\ClientStatus;
use Opg\Core\Model\Entity\CaseActor\Validation\Validator\MaritalStatus;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class ClientFilter
 * @package Opg\Core\Model\Entity\CaseActor\Validation\InputFilter
 */
class ClientFilter extends InputFilter
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
        $this->setMaritalStatusValidators();
        $this->setClientStatusValidators();
        $this->setClientAccommodationValidators();
    }


    protected function setMaritalStatusValidators()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'maritalStatus',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 2,
                                'max'      => 24,
                            ),
                        ),
                        new MaritalStatus()
                    )
                )
            )
        );
    }

    protected function setClientStatusValidators()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'clientStatus',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 2,
                                'max'      => 24,
                            ),
                        ),
                        new ClientStatus()
                    )
                )
            )
        );
    }

    protected function setClientAccommodationValidators()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'clientAccommodation',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name'    => 'StringLength',
                            'options' => array(
                                'encoding' => 'UTF-8',
                                'min'      => 2,
                                'max'      => 24,
                            ),
                        ),
                        new ClientAccommodation()
                    )
                )
            )
        );
    }
}
