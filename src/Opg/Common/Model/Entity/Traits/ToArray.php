<?php
namespace Opg\Common\Model\Entity\Traits;

/**
 * Class InputFilter
 *
 * @package Opg\Common\Model\Entity\Traits
 */
trait ToArray
{

    /**
     * @return array
     */
    public function toArray()
    {
        $data = get_object_vars($this);
        unset($data['inputFilter']);

        return $data;
    }
}
