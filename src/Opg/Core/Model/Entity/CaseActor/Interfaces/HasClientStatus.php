<?php

namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

/**
 * Interface HasClientStatus
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasClientStatus
{
    /**
     * @return string
     */
    public function getClientStatus();

    /**
     * @param string $status
     * @return HasClientStatus
     */
    public function setClientStatus($status);
}
