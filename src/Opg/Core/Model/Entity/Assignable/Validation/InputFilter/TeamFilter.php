<?php


namespace Opg\Core\Model\Entity\Assignable\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Core\Model\Entity\Assignable\Validation\Validator\TeamName;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class TeamFilter
 * @package Opg\Core\Model\Entity\Assignable\Validation\InputFilter
 */
class TeamFilter extends BaseInputFilter
{
    public function __construct()
    {
        $this->inputFactory = new InputFactory();

        $this->setValidators();
    }

    protected function setValidators()
    {
        $this->addValidator('name','Opg\Core\Model\Entity\Assignable\Validation\Validator\TeamName', true);
    }
}
