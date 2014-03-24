<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

trait RelationshipToDonor
{
    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string");
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
     * @return PartyInterface
     */
    public function setRelationshipToDonor($relationshipToDonor)
    {
        $this->relationshipToDonor = $relationshipToDonor;
        return $this;
    }
}
