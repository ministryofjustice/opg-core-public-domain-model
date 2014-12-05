<?php

namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

/**
 * Interface HasMaritalStatus
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasMaritalStatus
{
    /**
     * @return string
     */
    public function getMaritalStatus();

    /**
     * @param string $maritalStatus
     * @return HasMaritalStatus
     */
    public function setMaritalStatus($maritalStatus);
}
