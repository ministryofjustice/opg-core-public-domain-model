<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Core\Model\Entity\CaseItem\Validation\Validator\Applicants;

/**
 * Class PowerOfAttorneyFilter
 *
 * @package Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\InputFilter
 */
class PowerOfAttorneyFilter extends BaseInputFilter
{
    protected  function setValidators()
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
