<?php
namespace Opg\Common\Model\Entity;

use Zend\InputFilter\InputFilterAwareInterface;

/**
 * Interface EntityInterface
 * @package Opg\Common\Model\Entity
 */
interface EntityInterface extends InputFilterAwareInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @param array $data
     * @return EntityInterface
     */
    public function exchangeArray(array $data);
}
