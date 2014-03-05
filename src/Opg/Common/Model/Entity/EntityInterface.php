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
     * @param bool exposeClassname
     * @return array
     */
    public function toArray($exposeClassname = FALSE);

    /**
     * @param array $data
     * @return EntityInterface
     */
    public function exchangeArray(array $data);
}
