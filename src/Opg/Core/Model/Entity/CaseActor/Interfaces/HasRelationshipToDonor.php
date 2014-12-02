<?php
namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

/**
 * Interface HasRelationshipToDonor
 * @package Opg\Core\Model\Entity\CaseActor
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
