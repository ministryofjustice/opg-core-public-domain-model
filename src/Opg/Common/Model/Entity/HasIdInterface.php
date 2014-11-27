<?php

namespace Opg\Common\Model\Entity;

/**
 * Class HasId
 * @package Opg\Common\Model\Entity
 */
interface HasIdInterface
{
    /**
     * @param int $id
     * @return HasId
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getId();
}
