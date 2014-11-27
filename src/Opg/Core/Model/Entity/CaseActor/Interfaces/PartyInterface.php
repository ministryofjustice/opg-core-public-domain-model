<?php
namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface PartyInterface
 * @package Opg\Core\Model\Entity\CaseActor
 */
interface PartyInterface
{
    /**
     * @return ArrayCollection
     */
    public function getCases();

    /**
     * @param ArrayCollection $caseCollection
     *
     * @return PartyInterface
     */
    public function setCases(ArrayCollection $caseCollection);
}
