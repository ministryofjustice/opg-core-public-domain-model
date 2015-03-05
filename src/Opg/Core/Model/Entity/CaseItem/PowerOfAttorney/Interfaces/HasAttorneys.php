<?php

namespace Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\AttorneyAbstract;

/**
 * Interface HasAttorneys
 * @package Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Interfaces
 */
interface HasAttorneys
{

    /**
     * @return ArrayCollection
     */
    public function getAttorneys();

    /**
     * @param ArrayCollection $attorneys
     * @return HasAttorneys
     */
    public function setAttorneys(ArrayCollection $attorneys);

    /**
     * @param AttorneyAbstract $attorney
     * @return AttorneyAbstract
     */
    public function addAttorney(AttorneyAbstract $attorney);

    /**
     * @param AttorneyAbstract $attorney
     * @return bool
     */
    public function attorneyExists(AttorneyAbstract $attorney);

    /**
     * @param AttorneyAbstract $attorney
     * @return AttorneyAbstract
     */
    public function removeAttorney(AttorneyAbstract $attorney);

    /**
     * @param AttorneyAbstract $attorney
     * @return ArrayCollection
     */
    public function findAttorney(AttorneyAbstract $attorney);
}
