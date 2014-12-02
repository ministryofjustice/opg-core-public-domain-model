<?php

namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

/**
 * Interface HasClientAccommodation
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasClientAccommodation
{
    /**
     * @return string
     */
    public function getClientAccommodation();

    /**
     * @param string $accommodation
     * @return HasClientAccommodation
     */
    public function setClientAccommodation($accommodation);
}
