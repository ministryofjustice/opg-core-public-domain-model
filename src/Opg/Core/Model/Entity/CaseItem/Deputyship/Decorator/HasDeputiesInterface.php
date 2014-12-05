<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\Deputy;

/**
 * Interface HasDeputiesInterface
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
interface HasDeputiesInterface
{
    /**
     * @param Deputy $deputy
     * @return HasDeputiesInterface
     */
    public function addDeputy(Deputy $deputy);

    /**
     * @param ArrayCollection $deputies
     * @return HasDeputiesInterface
     */
    public function setDeputies(ArrayCollection $deputies);

    /**
     * @return ArrayCollection
     */
    public function getDeputies();

    /**
     * @param Deputy $deputy
     * @return boolean
     */
    public function hasDeputy(Deputy $deputy);

    /**
     * @param Deputy $deputy
     * @return HasDeputiesInterface
     */
    public function removeDeputy(Deputy $deputy);
}
