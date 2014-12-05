<?php


namespace Opg\Core\Model\Entity\CaseItem\Validation\InputFilter;


use Opg\Common\Filter\BaseInputFilter;

class OrderFilter extends BaseInputFilter
{
    protected function setValidators()
    {
        $this->addValidator('orderStatus', 'Opg\Core\Model\Entity\CaseItem\Validation\Validator\OrderStatus');
    }
}
