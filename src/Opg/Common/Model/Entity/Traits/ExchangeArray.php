<?php
namespace Opg\Common\Model\Entity\Traits;

trait ExchangeArray {

    public function exchangeArray(array $data)
    {
        $classData = get_class_vars(get_class($this));

        foreach($classData as $key=>$value) {
            if (gettype($value) === "boolean") {
                (!isset($data[$key])) ? : (bool)$this->{$key} = $data[$key];
            }
            else {
                (!isset($data[$key])) ? : $this->{$key} = $data[$key];
            }
        }

        return $this;
    }

}
