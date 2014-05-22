<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * Class Time
 *
 */
trait Time
{

    /**
     * @ORM\Column(type = "datetime", nullable = false)
     * @var \DateTime $createdTime
     * @Type("string")
     * @Accessor(getter="getCreatedTimeString", setter="setCreatedTimeString")
     */
    private $createdTime;

    /**
     * @return \DateTime $createdTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param \DateTime $createdTime
     *
     * @return $this
     */
    public function setCreatedTime(\DateTime $createdTime = null)
    {
        if (is_null($createdTime)) {
            $createdTime = new \DateTime();
        }
        $this->createdTime = $createdTime;

        return $this;
    }

    /**
     * @return string
     */
    public function getCreatedTimeString()
    {
        if (!empty($this->createdTime)) {
            return $this->createdTime->format(OPGDateFormat::getDateTimeFormat());
        }

        return '';
    }

    /**
     * @param string $createdTime
     *
     * @return $this
     */
    public function setCreatedTimeString($createdTime)
    {
        if (empty($createdTime)) {
            $createdTime = null;
        }

        return $this->setCreatedTime(new \DateTime($createdTime));
    }
}
