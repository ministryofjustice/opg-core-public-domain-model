<?php

namespace Opg\Core\Validation\Validator;

use Opg\Common\Model\Entity\LuhnCheckDigit;
use Zend\Validator\AbstractValidator;

/**
 * Class UniqueIdentifier
 * @package Opg\Core\Validation\Validator
 */
class UniqueIdentifier extends AbstractValidator
{
    const NOT_CORRECT_FORMAT = 'incorrectFormat';

    const CHECKSUM_NOT_VALID = 'invalidChecksum';


    /**
     * @var string
     */
    protected $uidRegexp = '/^(7\d{3}-\d{4}-\d{4}|7\d{11})$/';

    /**
     * @var array
     */
    protected $messageTemplates = array (
        self::NOT_CORRECT_FORMAT => "The uid '%value%' is not in the expected format",
        self::CHECKSUM_NOT_VALID => "The uid '%value%' did not validate against its checksum.",
    );

    /**
     * @param mixed $uid
     * @return bool|int
     */
    public function isValid($uid)
    {
        $result = true;

        $this->setValue(trim($uid));

        if (!preg_match($this->uidRegexp, $this->getValue())) {
            $this->error(self::NOT_CORRECT_FORMAT);
            $result &= false;
        }

        if (false ==  LuhnCheckDigit::validateNumber($uid)) {
            $this->error(self::CHECKSUM_NOT_VALID);
            $result &= false;
        }

        return $result;
    }
}
