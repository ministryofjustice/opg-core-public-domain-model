<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class PaymentMethod
 *
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Validator
 */
class PaymentMethod extends InArray
{
    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            [
                'CARD',
                'CHEQUE',
                'BACS',
            ]
        );
    }
}
