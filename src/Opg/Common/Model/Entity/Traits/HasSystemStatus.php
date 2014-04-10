<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * Class HasSystemStatus
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasSystemStatus
{
    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var bool
     * @Type("boolean")
     */
    protected $systemStatus;

    /**
     * @return bool
     */
    public function isActive()
    {
        return !empty($this->getStatus());
    }

    /**
     * @param bool $status
     * @return HasSystemStatusInterface
     */
    public function setStatus($status)
    {
        $this->systemStatus = (bool) $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->systemStatus;
    }
}
