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
    protected static $DateTimeFormat = 'd/m/Y H:i:s';

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

    /**
     * @param $strDateTime
     * @return bool|\DateTime
     */
    public static function createDateTime($strDateTime)
    {
        if (preg_match('/^[0-9]{1,2}\/[0-9]{4}\/[0-9]{1,2}$/', trim($strDateTime))) {
            return \DateTime::createFromFormat(self::getDateFormat(), $strDateTime);
        }

        if (preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/', trim($strDateTime))) {
            return \DateTime::createFromFormat(self::getDateTimeFormat(), $strDateTime);
        }
        return false;
    }
}
