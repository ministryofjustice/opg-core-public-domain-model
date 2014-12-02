<?php

namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasClientStatus;

/**
 * Class ClientStatus
 * @package Opg\Core\Model\Entity\CaseActor\Decorators
 */
trait ClientStatus
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
     */
    protected $clientStatus;

    /**
     * @return string
     */
    public function getClientStatus()
    {
        return $this->clientStatus;
    }

    /**
     * @param string $clientStatus
     * @return HasClientStatus
     */
    public function setClientStatus($clientStatus)
    {
        $this->clientStatus = $clientStatus;

        return $this;
    }
}
