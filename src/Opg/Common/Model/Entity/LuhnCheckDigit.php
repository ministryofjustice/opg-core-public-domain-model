<?php


namespace Opg\Common\Model\Entity;

/**
 * Class LuhnCheckDigit
 * @package Opg\Common\Model\Entity
 */
final class LuhnCheckDigit
{

    /**
     * @param int $number
     * @return int
     */
    public static function createCheckSum($number)
    {
       $checksum = 0;

        foreach (str_split(strrev((string) $number)) as $i => $d) {
            $checksum += ($i%2 === 0) ? $d * 2 : $d;
        }

        $checksum *= 9;

        $checksum = str_split((string) $checksum);
        return array_pop($checksum);
    }


    /**
     * @param $number
     * @return bool
     */
    public static function validateNumber($number)
    {
        $checksum = 0;

        $checkDigitArray = str_split((string) $number);
        $checkDigit = array_pop($checkDigitArray);

        $checkDigitArray = array_reverse($checkDigitArray);

        foreach ($checkDigitArray as $i => $d) {
            $checksum += ($i%2 === 0) ? $d * 2 : $d;
        }
        return ($checksum + $checkDigit) % 10 === 0;
    }
}
