<?php


namespace Opg\Core\Model\Entity\Assignable\Validation\InputFilter;

use Opg\Core\Model\Entity\Assignable\Validation\Validator\TeamName;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class TeamFilter
 * @package Opg\Core\Model\Entity\Assignable\Validation\InputFilter
 */
class TeamFilter extends InputFilter
{
    private $inputFactory;

    public function __construct()
    {
        $this->inputFactory = new InputFactory();

        $this->setValidators();
    }

    private function setValidators()
    {
        $this->setNameValidator();
    }

    private function setNameValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'name',
                    'required'   => true,
                    'validators' => array(
                        new TeamName()
                    )
                )
            )
        );
    }
}
