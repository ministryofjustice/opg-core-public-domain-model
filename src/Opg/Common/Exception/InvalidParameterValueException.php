<?php
namespace Opg\Common\Exception;

/**
 * Class InvalidParameterValueException
 * @package Opg\Common\Exception
 */
class InvalidParameterValueException extends OPGBaseException
{
    public function __construct($entity, $identifier, $code, $attribute)
    {
        parent::__construct(
            sprintf("The parameter %s's value of  %s is invalid", $entity, $identifier),
            self::CODE_DATA_INVALID,
            $attribute,
            'invalidFormat'
        );
    }
}
