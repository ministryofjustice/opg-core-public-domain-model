<?php
namespace Opg\Common\Model\Entity\Traits;

trait ExchangeArray {

    public function exchangeArray(array $data)
    {
        $classData = get_class_vars(get_class($this));

        foreach($classData as $key=>$value) {
            (!isset($data[$key])) ? : $this->{$key} = $data[$key];
        }

        return $this;
    }

}
