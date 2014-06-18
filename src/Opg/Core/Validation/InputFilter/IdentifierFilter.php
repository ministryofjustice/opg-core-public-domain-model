<?php

namespace Opg\Core\Validation\InputFilter;

use Opg\Core\Validation\Validator\IntegerOutOfRange;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;


/**
 * Class IdentifierFilter
 * @package Opg\Core\Validation\InputFilter
 */
class IdentifierFilter extends InputFilter
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
        $this->setIdentifierValidator();
    }

    protected function setIdentifierValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'id',
                    'required'   => false,
                    'validators' => array(
                        new IntegerOutOfRange(),
                    )
                )
            )
        );
    }
}
