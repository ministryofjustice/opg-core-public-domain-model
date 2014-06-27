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

    const INT_MIN_RANGE = -2147483648;

    const INT_OUT_OF_MAX_RANGE = 'outOfRange';

    const INT_OUT_OF_MIN_RANGE = 'underMinRange';

    protected $messageTemplates = array (
        self::INT_OUT_OF_MAX_RANGE => "'%value%' exceeds the maximum integer range allowed.",
        self::INT_OUT_OF_MIN_RANGE => "'%value%' exceeds the minimum integer range allowed.",
    );

    /**
     * @param mixed $number
     * @return bool
     */
    public function isValid($number)
    {
        $this->setValue($number);

        if ($number > self::INT_MAX_RANGE) {
            $this->error(self::INT_OUT_OF_MAX_RANGE);
            return false;
        }

        if ($number < self::INT_MIN_RANGE) {
            $this->error(self::INT_OUT_OF_MIN_RANGE);
            return false;
        }

        return true;
    }
}
