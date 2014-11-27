<?php
namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItem;

/**
 * Interface HasCasesInterface
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasCasesInterface
{
    /**
     * @return ArrayCollection
     */
    public function getCases();

    /**
     * @param ArrayCollection $caseCollection
     *
     * @return HasCasesInterface
     */
    public function setCases(ArrayCollection $caseCollection);

    /**
     * @param CaseItem $caseItem
     * @return HasCasesInterface
     */
    public function addCase(CaseItem $caseItem);

    /**
     * @param CaseItem $caseItem
     * @return HasCasesInterface
     */
    public function removeCase(CaseItem $caseItem);

    /**
     * @return bool
     */
    public function hasAttachedCase();
}
