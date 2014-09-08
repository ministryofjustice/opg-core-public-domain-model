<?php


namespace Opg\Common\Exception;

/**
 * Class InvalidParameterException
 * @package Opg\Common\Exception
 */
class ValidationFailureException extends \Exception
{
    public function __construct($className)
    {
        $message = sprintf('The class %s has invalid data.', $className);
        parent::__construct($message, OPGException::CODE_DATA_INVALID);
    }
}
