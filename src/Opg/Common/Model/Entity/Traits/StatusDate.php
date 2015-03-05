<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\HasStatusDate;

/**
 * Class StatusDate
 * @package Opg\Common\Model\Entity\Traits
 */
trait StatusDate
{
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="statusDate")
     * @Type("string")
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $statusDate;

    /**
     * @return \DateTime
     */
    public function getStatusDate()
    {
        return $this->statusDate;
    }

    /**
     * @param \DateTime $statusDate
     * @return HasStatusDate
     */
    public function setStatusDate(\DateTime $statusDate)
    {
        $this->statusDate = $statusDate;

        return $this;
    }
}
