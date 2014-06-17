<?php

namespace Opg\Core\Validation\Validator;

use Opg\Common\Model\Entity\LuhnCheckDigit;
use Zend\Validator\AbstractValidator;

/**
 * Class Checksum
 * @package Opg\Core\Validation\Validator
 */
class Checksum extends AbstractValidator
{
    const CHECKSUM_NOT_VALID = 'invalidChecksum';

    /**
     * @var array
     */
    protected $messageTemplates = array (
        self::CHECKSUM_NOT_VALID => 'The uid did not validate',
    );

    /**
     * @param int $uid
     * @return bool
     */
    public function isValid($uid)
    {
        $this->setValue($uid);

        return LuhnCheckDigit::validateNumber($uid);
    }
}
