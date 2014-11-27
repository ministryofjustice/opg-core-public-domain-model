<?php
namespace Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\InputFilter;

use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Validator\Applicants;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class PowerOfAttorneyFilter
 *
 * @package Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\InputFilter
 */
class PowerOfAttorneyFilter extends InputFilter
{
    /**
     * @var \Zend\InputFilter\Factory
     */
    private $inputFactory;

    public function __construct()
    {
        $this->inputFactory = new InputFactory();

        $this->setValidators();
    }

    private function setValidators()
    {
        $this->setAllowedCombinationsValidator();
    }

    private function setAllowedCombinationsValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'applicants',
                    'required'   => false,
                    'validators' => array(
                        new Applicants()
                    )
                )
            )
        );
    }
}
