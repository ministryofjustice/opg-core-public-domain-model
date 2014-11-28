<?php

namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Warning\Warning;

/**
 * Interface HasWarningInterface
 * @package Opg\Common\Model\Entity
 */
interface HasWarningsInterface
{

    /**
     * @return ArrayCollection
     */
    public function getWarnings();

    /**
     * @param ArrayCollection $warnings
     * @return HasWarningsInterface
     */
    public function setWarnings(ArrayCollection $warnings);

    /**
     * @param Warning $warning
     * @return HasWarningsInterface
     */
    public function addWarning(Warning $warning);

    /**
     * @return ArrayCollection
     */
    public function getActiveWarnings();

}
