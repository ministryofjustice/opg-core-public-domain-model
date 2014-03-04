<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\ApplicantCollection;

class ApplicantFilter extends InputFilter
{
    /**
     * @var Zend\InputFilter\Factory
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
                    'name'       => 'applicantCollection',
                    'required'   => false,
                    'validators' => array(
                        new ApplicantCollection()
                    )
                )
            )
        );
    }
}
