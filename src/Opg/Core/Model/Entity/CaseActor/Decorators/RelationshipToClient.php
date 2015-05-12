<?php
namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseActor\PartyInterface;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;

trait RelationshipToClient
{
    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-person-get")
     * @Type("string")
     */
    protected $relationshipToClient;

    /**
     * @return string
     */
    public function getRelationshipToClient()
    {
        return $this->relationshipToClient;
    }

    /**
     * @param string
     *
     * @return PartyInterface
     */
    public function setRelationshipToClient($relationshipToClient)
    {
        $this->relationshipToClient = $relationshipToClient;

        return $this;
    }
}
