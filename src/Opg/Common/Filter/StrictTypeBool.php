<?php

namespace Opg\Common\Filter;

class StrictTypeBool
{

    public static function apply($value) {
        if ($value === "0" or $value === "false" or $value == false) {
                   return false;
        }
        return true;
    }

}