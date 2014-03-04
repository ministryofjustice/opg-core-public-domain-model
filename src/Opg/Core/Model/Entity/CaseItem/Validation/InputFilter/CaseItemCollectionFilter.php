<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\InputFilter;

use Opg\Core\Model\Entity\CaseItem\Validation\Validator\CaseItemCollection;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class CaseItemCollectionFilter extends InputFilter
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
                    'name'       => 'caseItemCollection',
                    'required'   => false,
                    'validators' => array(
                        // @TODO does not seem to validate
                        new CaseItemCollection()
                    )
                )
            )
        );
    }
}
