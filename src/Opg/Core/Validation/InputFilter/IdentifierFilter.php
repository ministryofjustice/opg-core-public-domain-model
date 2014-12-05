<?php

namespace Opg\Core\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Core\Validation\Validator\IntegerOutOfRange;
use Zend\InputFilter\Factory as InputFactory;


/**
 * Class IdentifierFilter
 * @package Opg\Core\Validation\InputFilter
 */
class IdentifierFilter extends BaseInputFilter
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
