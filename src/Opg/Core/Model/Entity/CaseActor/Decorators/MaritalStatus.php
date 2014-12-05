<?php

namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasMaritalStatus;

/**
 * Class ClientStatus
 * @package Opg\Core\Model\Entity\CaseActor\Decorators
 */
trait MaritalStatus
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
     */
    protected $maritalStatus;

    /**
     * @return string
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * @param string $maritalStatus
     * @return HasMaritalStatus
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;

        return $this;
    }
}
