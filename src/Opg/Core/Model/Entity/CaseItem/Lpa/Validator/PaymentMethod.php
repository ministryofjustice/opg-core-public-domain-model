<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Validator;

use Zend\Validator\InArray;

class PaymentMethod extends InArray
{
    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);
        
        $this->setHaystack([
            'CARD',
            'CHEQUE',
            'BACS',
        ]);
    }
}
