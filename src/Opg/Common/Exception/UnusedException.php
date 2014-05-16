<?php
namespace Opg\Common\Exception;

/**
 * Class UnusedException
 * @package Opg\Common\Exception
 */
class UnusedException extends \Exception
{

    /**
     * @param null $message
     * @param null $code
     * @param null $previous
     */
    public function __construct(
        $message = null,
        $code = null,
        $previous = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
