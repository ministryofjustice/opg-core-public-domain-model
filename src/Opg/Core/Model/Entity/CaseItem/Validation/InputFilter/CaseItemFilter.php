<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\InputFilter;

use Opg\Core\Model\Entity\CaseItem\Validation\Validator\CaseItems;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class CaseItemFilter
 *
 * @package Opg\Core\Model\Entity\CaseItem\Validation\InputFilter
 */
class CaseItemFilter extends InputFilter
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
