<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface PartyInterface
 * @package Opg\Core\Model\Entity\CaseActor
 */
interface PartyInterface
{
    /**
     * @return string $id
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);

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
