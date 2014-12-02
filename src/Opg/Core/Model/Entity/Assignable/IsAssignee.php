<?php

namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItem as CaseEntity;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\PowerOfAttorney as PowerOfAttorneyEntity;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship as DeputyshipEntity;

/**
 * Interface IsAssignee
 * @package Opg\Core\Model\Entity\Assignable
 */
interface IsAssignee
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return IsAssignee
     */
    public function setName( $name );

    /**
     * @return string
     */
    public function getDisplayName();
}
