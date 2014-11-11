<?php

namespace Opg\Common\Model\Entity\Traits;

use JMS\Serializer\Annotation\GenericAccessor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Common\Model\Entity\HasDateTimeAccessor;

/**
 * Class DateTimeAccessor
 * @package Opg\Common\Model\Entity\Traits
 */
trait DateTimeAccessor
{
    /**
     * @param $propertyName
     * @return string
     */
    public function getDateAsString($propertyName)
    {
        if (isset($this->{$propertyName}) && $this->{$propertyName} instanceof \DateTime) {
            return $this->{$propertyName}->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param $propertyName
     * @return string|null
     */
    public function getDateTimeAsString($propertyName)
    {
        if (isset($this->{$propertyName}) && $this->{$propertyName} instanceof \DateTime) {
            return $this->{$propertyName}->format(OPGDateFormat::getDateTimeFormat());
        }

        return '';
    }

    /**
     * @param $value
     * @param $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDateTimeFromString($value, $propertyName)
    {
        if (property_exists(get_class($this), $propertyName) && !empty($value)) {
            $this->{$propertyName} = OPGDateFormat::createDateTime($value);
        }

        return $this;
    }

    /**
     * @param $value
     * @param $propertyName
     * @return HasDateTimeAccessor
     */
    public function setDateFromString($value, $propertyName)
    {
        return $this->setDateTimeFromString($value, $propertyName);
    }

    /**
     * @param $methodName
     * @param $params
     * @return HasDateTimeAccessor
     * @throws \LogicException
     */
    public function __call($methodName, $params)
    {
        if (preg_match('/(s|g)et[A-Za-z]+DateString/', $methodName)) {
            $parameter = str_replace('String','',$methodName);
            $parameter = lcfirst(substr($parameter,3));

            if (property_exists(get_class($this), $parameter)) {
                if (substr($methodName,0,3) === 'get') {
                    return $this->getDateAsString($parameter);
                } else {
                    return $this->setDateFromString($params[0], $parameter);
                }
            } else {
                throw new \LogicException('Parameter ' . $parameter . ' does not exist in class ' . get_class($this));
            }
        }

        return $this;
    }
}
