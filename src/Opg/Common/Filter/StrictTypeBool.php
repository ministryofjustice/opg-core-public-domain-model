<?php

namespace Opg\Common\Filter;

class StrictTypeBool
{
    /**
     * @param mixed $value
     * @return bool
     */
    public static function apply($value) {
        if ($value === "0" or $value === "false" or $value == false) {
                   return false;
        }
        return true;
    }

}