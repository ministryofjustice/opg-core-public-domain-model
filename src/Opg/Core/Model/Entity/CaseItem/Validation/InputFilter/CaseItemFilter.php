<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Core\Model\Entity\CaseItem\Validation\Validator\CaseItems;

/**
 * Class CaseItemFilter
 *
 * @package Opg\Core\Model\Entity\CaseItem\Validation\InputFilter
 */
class CaseItemFilter extends BaseInputFilter
{
    protected  function setValidators()
    {
        $this->setMinimumValidator();
    }

    private function setMinimumValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'caseItems',
                    'required'   => false,
                    'validators' => array(
                        // @TODO does not seem to validate
                        new CaseItems()
                    )
                )
            )
        );
    }
}
