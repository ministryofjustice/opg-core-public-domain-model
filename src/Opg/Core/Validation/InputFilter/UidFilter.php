<?php

namespace Opg\Core\Validation\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Core\Validation\Validator\Checksum;
use Opg\Core\Validation\Validator\UniqueIdentifier;

class UidFilter extends InputFilter
{
    /**
     * @var \Zend\InputFilter\Factory
     */
    protected $inputFactory;

    public function __construct()
    {
        $this->inputFactory = new InputFactory();
        $this->setValidators();
    }

    protected function setValidators()
    {
        $this->setMinimumValidator();
    }

    protected function setMinimumValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'uId',
                    'required'   => false,
                    'validators' => array(
                        new UniqueIdentifier(),
                        new Checksum(),
                    )
                )
            )
        );
    }
}
