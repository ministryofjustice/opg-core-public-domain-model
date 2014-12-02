<?php

namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasClientAccommodation;

/**
 * Class ClientAccommodation
 * @package Opg\Core\Model\Entity\CaseActor\Decorators
 */
trait ClientAccommodation
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
     */
    protected $clientAccommodation;

    /**
     * @return string
     */
    public function getClientAccommodation()
    {
        return $this->clientAccommodation;
    }

    /**
     * @param string $accommodation
     * @return HasClientAccommodation
     */
    public function setClientAccommodation($accommodation)
    {
        $this->clientAccommodation = $accommodation;

        return $this;
    }
}
