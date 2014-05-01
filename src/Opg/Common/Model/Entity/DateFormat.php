<?php


namespace Opg\Common\Model\Entity;

/**
 * Class DateFormat
 * @package Opg\Common\Model\Entity
 *
 * A standard definition on our dateTime formats as strings
 */
final class DateFormat
{
    /**
     * @var string
     */
    protected static $DateFormat = 'd/m/Y';

    /**
     * @var string
     */
    protected static $DateTimeFormat = 'd/m/Y h:i:s';

    /**
     * @return string
     */
    public static function getDateFormat()
    {
        return self::$DateFormat;
    }

    /**
     * @return string
     */
    public static function getDateTimeFormat()
    {
       return self::$DateTimeFormat;
    }
}
