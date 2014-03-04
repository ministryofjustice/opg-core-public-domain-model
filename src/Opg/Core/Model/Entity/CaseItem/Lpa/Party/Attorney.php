<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Traits\Party;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Person;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 *
 * @package Opg Core
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class Attorney implements PartyInterface
{
    use Party;
    use Person;
    use Company;
    use ToArray;
    
    /**
     * @var string
     */
    private $relationshipToDonor;
    
    /**
     * @var string
     */
    private $occupation;
    
    /**
     * @var boolean
     */
    private $isTrustCorporation;

    /**
     * @var boolean
     */
    private $isReplacementAttorney;
    
    /**
     * @return string $relationshipToDonor
     */
    public function getRelationshipToDonor()
    {
        return $this->relationshipToDonor;
    }

    /**
     * @param string $relationshipToDonor
     * @return Attorney
     */
    public function setRelationshipToDonor($relationshipToDonor)
    {
        $this->relationshipToDonor = $relationshipToDonor;
        return $this;
    }

    /**
     * @return string $occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     * @return Attorney
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
        return $this;
    }

    /**
     * @return boolean $isTrustCorporation
     */
    public function isTrustCorporation()
    {
        return $this->isTrustCorporation;
    }

    /**
     * @param boolean $isTrustCorporation
     * @return Attorney
     */
    public function setIsTrustCorporation($isTrustCorporation)
    {
        $this->isTrustCorporation = $isTrustCorporation;
        return $this;
    }

    /**
     * @return boolean $isReplacementAttorney
     */
    public function isReplacementAttorney()
    {
        return $this->isReplacementAttorney;
    }

    /**
     * @param boolean $isReplacementAttorney
     * @return Attorney
     */
    public function setIsReplacementAttorney($isReplacementAttorney)
    {
        $this->isReplacementAttorney = $isReplacementAttorney;
        return $this;
    }
}
