<?php

namespace Opg\Core\Model\Entity\CaseItem\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class OrderStatus
 * @package Opg\Core\Model\Entity\CaseItem\Validation\Validator
 */
class OrderStatus extends InArray
{
    static $orderStatus = array(
        "Active",
        "Inactive",
        "Full Order Expired",
        "No Further Proceedings",
        "Order Revoked",
        "Funds Exhausted",
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            self::$orderStatus
        );
    }
}
