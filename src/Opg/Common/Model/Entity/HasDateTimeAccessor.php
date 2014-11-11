<?php

namespace Opg\Common\Model\Entity;

/**
 * Interface HasDateTimeAccessor
 * @package Opg\Common\Model
 */
interface HasDateTimeAccessor
{

    /**
     * @param string $propertyName
     * @return string
     */
    public function getDateAsString($propertyName);

    /**
     * @param string $propertyName
     * @return string
     */
    public function getDateTimeAsString($propertyName);

    /**
     * @param string $value
     * @param string $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDateTimeFromString($value, $propertyName);

    /**
     * @param string $value
     * @param string $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDateFromString($value, $propertyName);
}
