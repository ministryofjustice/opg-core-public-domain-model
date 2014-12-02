<?php

namespace Opg\Common\Model\Entity;

/**
 * Interface HasStatusDate
 * @package Opg\Common\Model\Entity
 */
interface HasStatusDate
{
    /**
     * @return \DateTime
     */
    public function getStatusDate();

    /**
     * @param \DateTime $statusDate
     * @return HasStatusDate
     */
    public function setStatusDate(\DateTime $statusDate);
}
