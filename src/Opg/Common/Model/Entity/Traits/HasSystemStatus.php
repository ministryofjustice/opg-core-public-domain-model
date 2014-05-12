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
     * @ORM\Column(type = "boolean",options={"default":1})
     * @var bool
     * @Type("boolean")
     */
    protected $systemStatus = true;

    /**
     * @return bool
     */
    public function isActive()
    {
        return !empty($this->getSystemStatus());
    }

    /**
     * @param bool $status
     *
     * @return HasSystemStatusInterface
     */
    public function setSystemStatus($status)
    {
        $this->systemStatus = (bool)$status;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSystemStatus()
    {
        return (bool)$this->systemStatus;
    }
}
