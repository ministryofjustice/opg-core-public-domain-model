<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\EntityInterface;

/**
 * Class InputFilter
 *
 * @package Opg\Common\Model\Entity\Traits
 */
trait ToArray
{

    /**
     * Method to traverse the data model and return itself plus all attached
     * objects all nicely flattened out
     *
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = false)
    {
        $data = array();

        $classData = get_object_vars($this);
        unset($classData['inputFilter']);

        foreach ($classData as $name => $value) {
            if (is_array(
                    $value
                ) && isset($value[0]) && ($value[0] instanceof EntityInterface || $value[0] instanceof ArrayCollection)
            ) {
                $entryArray = [];
                foreach ($value as $entry) {
                    $entryArray[] = $entry->toArray();
                }
                $data[$name] = $entryArray;
            } elseif (is_object($value) && ($value instanceof ArrayCollection || $value instanceof EntityInterface)) {
                $data[$name] = $value->toArray();
            } else {
                $data[$name] = $value;
            }
        }

        if (true === $exposeClassname) {
            $data['className'] = __CLASS__;
        }

        return $data;
    }

    /**
     * Hopefully this will replace the above with a simpler recursive walk of the object
     *
     * @param boolean  $exposeClassname
     * @param stdClass $baseObject
     *
     * @return array
     */
    public function toArrayRecursive($exposeClassname = false, $baseObject = null)
    {
        $data = array();

        $baseObject = (is_null($baseObject)) ? $this : $baseObject;

        $arrObj = is_object($baseObject) ? get_object_vars($baseObject) : $baseObject;

        foreach ($arrObj as $key => $val) {
            $val        = (is_array($val) || is_object($val)) ? $this->toArrayRecursive($exposeClassname, $val) : $val;
            $data[$key] = $val;
        }

        if (true === $exposeClassname) {
            $data['className'] = __CLASS__;
        }

        return $data;
    }
}
