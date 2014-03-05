<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Defines an interface for reponsible parties declared
 * as part of a Lasting Power of Attorney registration
 *
 * @package Opg Core Domain Model
 *
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
