<?php


namespace Opg\Common\Model\Entity;

/**
 * Class DateFormat
 * @package Opg\Common\Model\Entity
 *
 * A standard definition on our dateTime formats as strings
 */

use Opg\Common\Model\Entity\Exception\InvalidDateFormatException;

final class DateFormat
{
    const REGEXP_DATE_ONLY = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';

    const REGEXP_DATE_TIME = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/';

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
     * @return \DateTime
     * @throws Exception\InvalidDateFormatException
     */
    public static function createDateTime($strDateTime)
    {
        if (preg_match(self::REGEXP_DATE_ONLY, trim($strDateTime))) {
            return \DateTime::createFromFormat(self::getDateFormat(), $strDateTime);
        }

        if (preg_match(self::REGEXP_DATE_TIME, trim($strDateTime))) {
            return \DateTime::createFromFormat(self::getDateTimeFormat(), $strDateTime);
        }

        throw new InvalidDateFormatException("'{$strDateTime}' was not in the expected format "
            . self::getDateTimeFormat());
    }
}
