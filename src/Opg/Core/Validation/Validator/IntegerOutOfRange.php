<?php

namespace Opg\Core\Validation\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class IntegerOutOfRange
 * @package Opg\Core\Validation\Validator
 */
class IntegerOutOfRange extends AbstractValidator
{
    const INT_MAX_RANGE = 2147483647;

    const INT_OUT_OF_RANGE = 'outOfRange';

    protected $messageTemplates = array (
        self::INT_OUT_OF_RANGE => "'%value%' exceeds the maximum integer range allowed.",
    );

    /**
     * @param mixed $number
     * @return bool
     */
    public function isValid($number)
    {
        $this->setValue($number);

        if ($number > self::INT_MAX_RANGE) {
            $this->error(self::INT_OUT_OF_RANGE);
            return false;
        }

        return true;
    }
}
