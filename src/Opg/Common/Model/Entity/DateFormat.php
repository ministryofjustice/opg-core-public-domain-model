<?php
namespace Opg\Common\Model\Entity;

use Opg\Common\Model\Entity\Exception\InvalidDateFormatException;

/**
 * Class DateFormat
 * @package Opg\Common\Model\Entity
 *
 * A standard definition on our dateTime formats as strings
 */
final class DateFormat
{
    const REGEXP_DATE_ONLY = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/';

    const REGEXP_DATE_TIME = '/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/';

    const REGEXP_MYSQL_DATE_TIME = '/[0-9]{4}-[0-9]{1,2}-[0-9]{1,2} [0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$/';
    /**
     * @var string
     */
    protected static $DateFormat = 'd/m/Y';

    /**
     * @var string
     */
    protected static $DateTimeFormat = 'd/m/Y H:i:s';

    /**
     * @var string
     */
    protected static $DateTimeSqlExport = 'Y-m-d H:i:s';

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
     * @return string
     */
    public static function getSqlDateTimeFormat()
    {
        return self::$DateTimeSqlExport;
    }

    /**
     * @param $strDateTime
     *
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

        if (preg_match(self::REGEXP_MYSQL_DATE_TIME, trim($strDateTime))) {
            return \DateTime::createFromFormat(self::$DateTimeMysqlExport, $strDateTime);
        }

        throw new InvalidDateFormatException(
            "'{$strDateTime}' was not in the expected format " . self::getDateTimeFormat()
        );
    }
}
