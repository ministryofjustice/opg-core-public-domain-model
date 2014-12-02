<?php

namespace Opg\Common\Filter;

use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

/**
 * Class BaseInputFilter
 * @package Opg\Common\Filter
 */
class BaseInputFilter extends InputFilter
{
    /** @var Factory */
    protected  $inputFactory;

    protected function addValidator($inputName, $className, $required = false)
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => $inputName,
                    'required'   => $required,
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
                        new $className()
                    )
                )
            )
        );
    }

    public function __construct()
    {
        $this->inputFactory = new Factory();

        $this->setValidators();
    }

    /**
     * @param InputFilter $filter
     */
    public function merge(InputFilter $filter)
    {
        foreach ($filter->getInputs() as $input) {
            $this->add($input);
        }
    }

    protected function setValidators()
    {

    }
}
