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
     * This feature is coming in ZF 2.4 see
     * https://github.com/brettminnie/zf2-documentation/blob/85394c76c3fc83541f17b7822d100d7d4ce2e748/docs/languages/en/modules/zend.input-filter.intro.rst
     */
    public function merge(InputFilter $filter)
    {
        foreach ($filter->getInputs() as $input) {
            $this->add($input);
        }
    }

    /**
     * This can be overridden in calling classes, however I wanted to  be able to instanciate this class as a base
     */
    protected function setValidators()
    {
    }
}
