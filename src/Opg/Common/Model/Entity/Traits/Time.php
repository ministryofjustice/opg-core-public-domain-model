<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

/**
 * Class Time
 *
 */
trait Time {

    /**
     * @ORM\Column(type = "string")
     * @var string createdTime
     * @Type("string")
     */
    private $createdTime;

    /**
     * @return string $createdTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param string $createdTime A string that can be parsed by strtotime
     */
    public function setCreatedTime($createdTime = 'Now')
    {
        $timestamp = strtotime($createdTime);

        $this->createdTime = date('Y-m-d\TH:i:s', $timestamp);
        return $this;
    }
}
