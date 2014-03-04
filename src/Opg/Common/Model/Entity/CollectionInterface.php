<?php
namespace Opg\Common\Model\Entity;

use Zend\InputFilter\InputFilterAwareInterface;

/**
 * Interface CollectionInterface
 * @package Opg\Common\Model\Entity
 */
interface CollectionInterface extends InputFilterAwareInterface
{
    /**
     * @return array
     */
    public function toArray();

    /**
     * @param array $data
     * @return CollectionInterface
     */
    public function exchangeArray(array $data);
}
