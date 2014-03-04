<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\CaseItemCollection;

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
     * @return CaseItemCollection
     */
    public function getCases();
    
    /**
     * @param CaseItemCollection
    */
    public function setCases(CaseItemCollection $caseCollection);
}
