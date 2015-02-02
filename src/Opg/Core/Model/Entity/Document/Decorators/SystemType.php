<?php

namespace Opg\Core\Model\Entity\Document\Decorators;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Class AssetLog
 * @package Opg\Core\Model\Entity\Document\Decorators
 */
trait SystemType
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @Groups({"api-person-get"})
     * @var string
     */
    protected $systemType;

    /**
     * @param string $systemType
     * @return HasSystemType
     */
    public function setSystemType($systemType)
    {
        $this->systemType = $systemType;

        return $this;
    }

    /**
     * @return string
     */
    public function getSystemType()
    {
        return $this->systemType;
    }
}
