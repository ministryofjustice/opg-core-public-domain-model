<?php

namespace Opg\Common\Model\Entity;

/**
 * Interface HasSystemStatusInterface
 * @package Opg\Common\Model\Entity
 */
interface HasSystemStatusInterface
{

    /**
     * @return boolean
     */
    public function isActive();

    /**
     * @param boolean $active
     * @return HasSystemStatusInterface
     */
    public function setStatus($active);

    /**
     * @return boolean
     */
    public function getStatus();
}
