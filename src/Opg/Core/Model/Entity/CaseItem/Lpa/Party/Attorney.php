<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class Attorney extends BasePerson implements  PartyInterface, EntityInterface
{
    use Company;
    use ToArray {
        toArray as traitToArray;
    }
    use ExchangeArray;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $relationshipToDonor;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $occupation;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $isTrustCorporation = false;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $isReplacementAttorney = false;

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

    /**
     * @return void|InputFilterInterface
     * @throws \Opg\Common\Exception\UnusedException
     */
    public function getInputFilter()
    {
        throw new UnusedException();
    }

    /**
     * @param InputFilterInterface $inputFilter
     *
     * @return void|\Zend\InputFilter\InputFilterAwareInterface
     * @throws \Opg\Common\Exception\UnusedException
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new UnusedException();
    }

    /**
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = TRUE) {
        return $this->traitToArray($exposeClassname);
    }
}
