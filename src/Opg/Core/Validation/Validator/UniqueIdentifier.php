<?php

namespace Opg\Core\Validation\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class UniqueIdentifier
 * @package Opg\Core\Validation\Validator
 */
class UniqueIdentifier extends AbstractValidator
{
    const NOT_CORRECT_FORMAT = 'incorrectFormat';

    /**
     * @var string
     */
    protected $uidRegexp = '/^(7\d{3}-\d{4}-\d{4}|7\d{11})$/';

    /**
     * @var array
     */
    protected $messageTemplates = array (
        self::NOT_CORRECT_FORMAT => 'The uid is not in the expected format',
    );

    /**
     * @param mixed $uid
     * @return bool|int
     */
    public function isValid($uid)
    {
        $this->setValue(trim($uid));
        $returnValue = preg_match($this->uidRegexp, $this->getValue());
        return $returnValue;
    }
}
