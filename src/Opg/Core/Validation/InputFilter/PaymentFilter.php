<?php

namespace Opg\Core\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class PaymentFilter
 * @package Opg\Core\Validation\InputFilter
 */
class PaymentFilter extends BaseInputFilter
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

    /**
     * Sets the validators
     */
    protected function setValidators()
    {
        $this->setPaymentAmountValidator();
        $this->setPaymentAmountGreaterThanZero();
        $this->setFeeNumberValidator();
    }

    /**
     * Ensures we have a payment reference set
     */
    protected function setFeeNumberValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'paymentReference',
                    'required'   => true,
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
                            )
                        )
                    )
                )
            )
        );
    }

    /**
     * Ensures our amount is numeric
     */
    protected function setPaymentAmountValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'paymentAmount',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'Digits',
                        )
                    )
                )
            )
        );
    }

    /**
     * Ensure we have a non zero, non negative amount
     */
    protected function setPaymentAmountGreaterThanZero()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'paymentAmount',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'GreaterThan',
                            'options' => array(
                                'min'      =>  0,
                            )
                        )
                    )
                )
            )
        );
    }

}
