<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

/**
 * Interface HasRelationshipToDonor
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
interface HasRelationshipToDonor
{
    /**
     * @return string
     */
    public function getRelationshipToDonor();

    /**
     * @param string
     *
     * @return PartyInterface
     */
    public function setRelationshipToDonor($relationshipToDonor);
}
