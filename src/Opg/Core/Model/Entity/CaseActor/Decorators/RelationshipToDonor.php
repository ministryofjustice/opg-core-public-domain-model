<?php
namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RelationshipToDonor
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Traits
 */
trait RelationshipToDonor
{
    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $relationshipToDonor;

    /**
     * @return string
     */
    public function getRelationshipToDonor()
    {
        return $this->relationshipToDonor;
    }

    /**
     * @param string
     *
     * @return PartyInterface
     */
    public function setRelationshipToDonor($relationshipToDonor)
    {
        $this->relationshipToDonor = $relationshipToDonor;

        return $this;
    }
}
